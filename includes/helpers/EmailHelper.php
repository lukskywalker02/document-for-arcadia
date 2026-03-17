<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Helpers\EmailHelper
 * 📂 Physical File:   includes/helpers/EmailHelper.php
 * 
 * 📝 Description:
 * Helper class for sending emails using PHPMailer.
 * This class simplifies the process of sending emails in the application.
 * 
 * 🔗 Dependencies:
 * - PHPMailer (via Composer)
 */

// Cargamos el autoloader de Composer para poder usar PHPMailer
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class EmailHelper
{
    /**
     * Configura y retorna una instancia de PHPMailer lista para usar
     * 
     * Este método se encarga de configurar todas las opciones necesarias
     * para enviar emails: servidor SMTP, autenticación, etc.
     * 
     * @return PHPMailer Una instancia configurada de PHPMailer
     * @throws Exception Si hay un error al configurar PHPMailer
     */
    private static function getMailer()
    {
        // Create a new PHPMailer instance
        // true as parameter enables exception handling
        $mail = new PHPMailer(true);

        try {
            // Cargamos las variables de entorno desde el archivo .env
            // This allows us to store sensitive information (like passwords) outside the code
            // Usamos try-catch para manejar errores de parsing
            try {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->safeLoad(); // safeLoad() no lanza excepciones si el archivo no existe
            } catch (Exception $e) {
                // If there is a parsing error, log it but continue with default values
                error_log("Warning: Error parsing .env file: " . $e->getMessage());
                // Continue with default values instead of failing completely
            }

            // Configuramos el servidor SMTP
            // SMTP es el protocolo que se usa para enviar emails
            $mail->isSMTP();
            
            // SMTP server address (e.g., smtp.gmail.com, smtp.outlook.com)
            // If not configured, use localhost by default (useful for development)
            $mail->Host = $_ENV['SMTP_HOST'] ?? 'localhost';
            
            // Enable SMTP authentication (required for most servers)
            $mail->SMTPAuth = true;
            
            // Usuario para autenticarse en el servidor SMTP
            $mail->Username = $_ENV['SMTP_USER'] ?? '';
            
            // Password to authenticate with the SMTP server
            $mail->Password = $_ENV['SMTP_PASS'] ?? '';
            
            // Encryption type (TLS or SSL)
            // TLS is more modern and secure than SSL
            // In .env you can use: 'tls', 'ssl', or leave empty
            $smtpSecure = $_ENV['SMTP_SECURE'] ?? 'tls';
            if ($smtpSecure === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } elseif ($smtpSecure === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Default TLS
            }
            
            // Puerto del servidor SMTP
            // 587 is the standard port for TLS, 465 for SSL
            $mail->Port = $_ENV['SMTP_PORT'] ?? 587;
            
            // Character encoding (UTF-8 supports all languages)
            $mail->CharSet = 'UTF-8';
            
            // Email from which it is sent (sender)
            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'] ?? 'noreply@arcadia-zoo.com', $_ENV['SMTP_FROM_NAME'] ?? 'Arcadia Zoo');
            
            // In development mode, we can disable SSL verification
            // ⚠️ IMPORTANT: In production, this must be false for security
            if ($_ENV['APP_ENV'] === 'development') {
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            }

        } catch (Exception $e) {
            // If there is an error, log it and throw the exception
            error_log("Error configurando PHPMailer: " . $e->getMessage());
            throw $e;
        }

        return $mail;
    }

    /**
     * Verifica si la configuración de email está completa
     * 
     * Este método valida que todas las variables de entorno necesarias
     * estén configuradas antes de intentar enviar un email.
     * 
     * @return array ['valid' => bool, 'message' => string] 
     *               Indica si la configuración es válida y un mensaje descriptivo
     */
    private static function validateEmailConfig()
    {
        // Cargamos las variables de entorno
        // Usamos try-catch para manejar errores de parsing del archivo .env
        try {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->safeLoad(); // safeLoad() no lanza excepciones, solo retorna false si hay error
        } catch (Exception $e) {
            // Si hay un error al cargar el .env, lo registramos y retornamos error
            error_log("Error loading .env file: " . $e->getMessage());
            return [
                'valid' => false,
                'message' => 'Error en el archivo .env. Verifica el formato. Error: ' . $e->getMessage()
            ];
        }

        // Verificamos cada variable necesaria
        $requiredVars = [
            'SMTP_HOST' => 'Servidor SMTP',
            'SMTP_USER' => 'Usuario SMTP',
            'SMTP_PASS' => 'Contraseña SMTP',
            'SMTP_FROM_EMAIL' => 'Email remitente'
        ];

        $missing = [];
        foreach ($requiredVars as $var => $description) {
            if (empty($_ENV[$var])) {
                $missing[] = $description . " ({$var})";
            }
        }

        if (!empty($missing)) {
            return [
                'valid' => false,
                'message' => 'Configuración de email incompleta. Faltan: ' . implode(', ', $missing) . 
                           '. Por favor, crea un archivo .env en la raíz del proyecto con estas variables.'
            ];
        }

        return ['valid' => true, 'message' => 'Configuración válida'];
    }

    /**
     * Envía un email informativo cuando se crea una nueva cuenta de usuario
     * 
     * Según el enunciado del TP, cuando el administrador crea una cuenta,
     * se debe enviar un email al usuario con su username (pero NO el password).
     * El password debe ser entregado en persona por el administrador.
     * 
     * @param string $toEmail Email del destinatario (el nuevo usuario)
     * @param string $username Username que se le asignó al usuario
     * @param string $roleName Nombre del rol asignado (ej: "Employé", "Vétérinaire")
     * @return array ['success' => bool, 'message' => string] 
     *               Indica si el email se envió y un mensaje descriptivo
     */
    public static function sendAccountCreationEmail($toEmail, $username, $roleName)
    {
        // STEP 1: VALIDATE CONFIGURATION
        // Before attempting to send, verify that the configuration is complete
        $configCheck = self::validateEmailConfig();
        if (!$configCheck['valid']) {
            // If configuration is invalid, log error and return false
            error_log("Error en configuración de email: " . $configCheck['message']);
            return ['success' => false, 'message' => $configCheck['message']];
        }

        try {
            // PASO 2: OBTENER INSTANCIA DE PHPMailer CONFIGURADA
            // Obtenemos una instancia configurada de PHPMailer con todas las opciones SMTP
            $mail = self::getMailer();

            // PASO 3: CONFIGURAR DESTINATARIO
            // Configuramos el destinatario del email
            $mail->addAddress($toEmail);

            // PASO 4: CONFIGURAR ASUNTO Y CONTENIDO
            // Asunto del email
            $mail->Subject = 'Bienvenue à Arcadia Zoo - Votre compte a été créé';

            // Cuerpo del email en formato HTML
            // Use HTML for a more professional looking email
            $mail->isHTML(true);
            
            // Construimos el contenido del email con un diseño atractivo
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background-color: #2d5016; color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; background-color: #f9f9f9; }
                        .info-box { background-color: #e8f5e9; border-left: 4px solid #2d5016; padding: 15px; margin: 20px 0; }
                        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>🦁 Arcadia Zoo</h1>
                        </div>
                        <div class='content'>
                            <h2>Bienvenue dans l'équipe !</h2>
                            <p>Votre compte a été créé avec succès par l'administrateur.</p>
                            
                            <div class='info-box'>
                                <p><strong>Votre nom d'utilisateur :</strong> {$username}</p>
                                <p><strong>Votre rôle :</strong> {$roleName}</p>
                            </div>
                            
                            <p><strong>Important :</strong> Pour obtenir votre mot de passe, veuillez vous rapprocher de l'administrateur.</p>
                            
                            <p>Vous pouvez maintenant vous connecter à l'application en utilisant votre nom d'utilisateur.</p>
                        </div>
                        <div class='footer'>
                            <p>Arcadia Zoo - Depuis 1960</p>
                            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            // Versión en texto plano (por si el cliente de email no soporta HTML)
            $mail->AltBody = "Bienvenue à Arcadia Zoo\n\n" .
                           "Votre compte a été créé avec succès.\n\n" .
                           "Nom d'utilisateur : {$username}\n" .
                           "Rôle : {$roleName}\n\n" .
                           "Important : Pour obtenir votre mot de passe, veuillez vous rapprocher de l'administrateur.\n\n" .
                           "Arcadia Zoo - Depuis 1960";

            // PASO 5: ENVIAR EL EMAIL
            // Enviamos el email usando el método send() de PHPMailer
            $mail->send();
            
            // Si llegamos aquí, el email se envió correctamente
            return ['success' => true, 'message' => 'Email enviado exitosamente a: ' . $toEmail];

        } catch (Exception $e) {
            // Si hay un error, lo registramos en el log del servidor con detalles completos
            // Esto es importante para poder debuggear problemas de envío
            $errorMessage = "Error enviando email de creación de cuenta a {$toEmail}: " . $e->getMessage();
            error_log($errorMessage);
            
            // También guardamos información adicional del error para debugging
            error_log("Detalles del error: " . print_r([
                'to' => $toEmail,
                'username' => $username,
                'smtp_host' => $_ENV['SMTP_HOST'] ?? 'no configurado',
                'smtp_user' => $_ENV['SMTP_USER'] ?? 'no configurado',
                'error' => $e->getMessage()
            ], true));
            
            // Retornamos false con un mensaje descriptivo
            return [
                'success' => false, 
                'message' => 'Error al enviar email: ' . $e->getMessage() . 
                           '. Verifica la configuración SMTP en el archivo .env'
            ];
        }
    }

    /**
     * Envía un email al zoo cuando un visitante envía el formulario de contacto
     * 
     * Este método envía un email al zoo con los datos del formulario de contacto
     * para que el empleado pueda responder directamente por email.
     * 
     * @param string $toEmail - Email del zoo (destinatario)
     * @param string $firstName - Nombre del visitante
     * @param string $lastName - Apellido del visitante
     * @param string $visitorEmail - Email del visitante (para responder)
     * @param string $subject - Asunto del mensaje
     * @param string $message - Mensaje del visitante
     * @return array - Array con 'success' (bool) y 'message' (string)
     */
    public static function sendContactFormEmail($toEmail, $firstName, $lastName, $visitorEmail, $subject, $message)
    {
        try {
            // Obtenemos una instancia de PHPMailer configurada
            $mail = self::getMailer();

            // PASO 1: CONFIGURAR DESTINATARIO
            // El email se envía al zoo
            $mail->addAddress($toEmail);

            // PASO 2: CONFIGURAR ASUNTO
            // El asunto incluye el asunto del visitante
            $mail->Subject = "Nouveau message de contact - " . htmlspecialchars($subject);

            // PASO 3: CONFIGURAR REMITENTE Y REPLY-TO
            // El remitente es el sistema, pero el Reply-To es el email del visitante
            // Esto permite que el empleado responda directamente al visitante
            $mail->addReplyTo($visitorEmail, $firstName . ' ' . $lastName);

            // PASO 4: CONFIGURAR CONTENIDO DEL EMAIL
            // Cuerpo del email en formato HTML
            $mail->isHTML(true);
            
            // Construimos el contenido del email con un diseño atractivo
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background-color: #2d5016; color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; background-color: #f9f9f9; }
                        .info-box { background-color: #e8f5e9; border-left: 4px solid #2d5016; padding: 15px; margin: 20px 0; }
                        .message-box { background-color: white; border: 1px solid #ddd; padding: 15px; margin: 20px 0; border-radius: 5px; }
                        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                        .reply-note { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>🦁 Arcadia Zoo - Nouveau message de contact</h1>
                        </div>
                        <div class='content'>
                            <h2>Vous avez reçu un nouveau message de contact</h2>
                            
                            <div class='info-box'>
                                <p><strong>De :</strong> " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</p>
                                <p><strong>Email :</strong> <a href='mailto:" . htmlspecialchars($visitorEmail) . "'>" . htmlspecialchars($visitorEmail) . "</a></p>
                                <p><strong>Sujet :</strong> " . htmlspecialchars($subject) . "</p>
                                <p><strong>Date :</strong> " . date('d/m/Y à H:i') . "</p>
                            </div>
                            
                            <div class='message-box'>
                                <h3>Message :</h3>
                                <p>" . nl2br(htmlspecialchars($message)) . "</p>
                            </div>
                            
                            <div class='reply-note'>
                                <p><strong>💡 Pour répondre :</strong> Utilisez simplement le bouton \"Répondre\" de votre client de messagerie. 
                                L'email sera automatiquement envoyé à " . htmlspecialchars($visitorEmail) . "</p>
                            </div>
                        </div>
                        <div class='footer'>
                            <p>Arcadia Zoo - Depuis 1960</p>
                            <p>Cet email a été envoyé automatiquement depuis le formulaire de contact du site web.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            // Versión en texto plano
            $mail->AltBody = "Nouveau message de contact - Arcadia Zoo\n\n" .
                           "De : " . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "\n" .
                           "Email : " . htmlspecialchars($visitorEmail) . "\n" .
                           "Sujet : " . htmlspecialchars($subject) . "\n" .
                           "Date : " . date('d/m/Y à H:i') . "\n\n" .
                           "Message :\n" . htmlspecialchars($message) . "\n\n" .
                           "Pour répondre, utilisez simplement le bouton \"Répondre\" de votre client de messagerie.\n\n" .
                           "Arcadia Zoo - Depuis 1960";

            // PASO 5: ENVIAR EL EMAIL
            $mail->send();
            
            return ['success' => true, 'message' => 'Email enviado exitosamente al zoo'];

        } catch (Exception $e) {
            $errorMessage = "Error enviando email de contacto al zoo: " . $e->getMessage();
            error_log($errorMessage);
            
            error_log("Detalles del error: " . print_r([
                'to' => $toEmail,
                'visitor_email' => $visitorEmail,
                'subject' => $subject,
                'smtp_host' => $_ENV['SMTP_HOST'] ?? 'no configurado',
                'error' => $e->getMessage()
            ], true));
            
            return [
                'success' => false, 
                'message' => 'Error al enviar email: ' . $e->getMessage() . 
                           '. Verifica la configuración SMTP en el archivo .env'
            ];
        }
    }
}

