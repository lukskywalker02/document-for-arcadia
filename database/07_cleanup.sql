-- ============================================================
-- CLEANUP JOBS FOR DATABASE MAINTENANCE
-- ============================================================
-- These queries should be run periodically (monthly via cron/scheduled task)
-- ============================================================

-- ============================================================
-- 1. CLEANUP: animal_clicks (Keep only last 12 months)
-- ============================================================
-- Run this monthly to prevent infinite growth
DELETE FROM animal_clicks 
WHERE year < YEAR(CURDATE()) - 1 
   OR (year = YEAR(CURDATE()) - 1 AND month < MONTH(CURDATE()));

-- ============================================================
-- 2. CLEANUP: form_contact (Keep sent emails for 6 months)
-- ============================================================
-- Run this monthly to archive old sent emails
-- Keeps unsent emails indefinitely for troubleshooting
DELETE FROM form_contact 
WHERE email_sent = TRUE 
  AND f_sent_date < DATE_SUB(NOW(), INTERVAL 6 MONTH);

-- ============================================================
-- 3. CLEANUP: psw_reset_token (Remove expired tokens)
-- ============================================================
-- NOTA: Esta tabla fue eliminada porque la funcionalidad de
-- recuperación de contraseña NO está especificada en el PDF del TP.
-- Ver: database/2025_12_31_remove_psw_reset_token.sql
-- 
-- DELETE FROM psw_reset_token 
-- WHERE expires_at < NOW();

-- ============================================================
-- OPTIONAL: Add indexes for better cleanup performance
-- ============================================================
-- These are already included in the optimization scripts
-- but listed here for reference:
-- 
-- animal_clicks: idx_year_month (year, month)
-- form_contact: idx_sent_date (f_sent_date)
-- psw_reset_token: idx_expires_at (expires_at) - if not exists

