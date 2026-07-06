<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Advanced database features: stored procedures,
     * stored functions, and check constraints.
     */
    public function up(): void
    {
        // Drop existing procedures/functions (idempotent)
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_dashboard_statistics");


        // 4. Create Stored Procedure: sp_get_dashboard_statistics
        DB::unprepared("
            CREATE PROCEDURE sp_get_dashboard_statistics(
                OUT out_total_links INT,
                OUT out_active_links INT,
                OUT out_avg_response_time INT,
                OUT out_most_active_category VARCHAR(100)
            )
            BEGIN
                -- Aggregate query
                SELECT 
                    COUNT(*),
                    SUM(IF(status = 'aktif', 1, 0)),
                    AVG(IF(status_response_time_ms IS NOT NULL, status_response_time_ms, 0))
                INTO 
                    out_total_links,
                    out_active_links,
                    out_avg_response_time
                FROM t_link;

                -- Subquery with aggregates to find the category with the most links
                BEGIN
                    DECLARE max_cat_id INT;
                    SELECT id_kategori INTO max_cat_id
                    FROM t_link 
                    WHERE id_kategori IS NOT NULL
                    GROUP BY id_kategori 
                    ORDER BY COUNT(id_link) DESC 
                    LIMIT 1;

                    IF max_cat_id IS NOT NULL THEN
                        SELECT nama_kategori INTO out_most_active_category
                        FROM t_kategori
                        WHERE id_kategori = max_cat_id
                        LIMIT 1;
                    ELSE
                        SET out_most_active_category = 'Tidak Ada';
                    END IF;
                END;
            END
        ");



        // 6. Add CHECK Constraint (MySQL 8.0+)
        try {
            DB::unprepared("
                ALTER TABLE t_link
                ADD CONSTRAINT chk_link_status
                CHECK (status IN ('aktif', 'bermasalah'))
            ");
        } catch (\Throwable $e) {
            // Fallback: older MySQL versions may not support CHECK constraints
        }
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_dashboard_statistics");


        try {
            DB::unprepared("ALTER TABLE t_link DROP CONSTRAINT IF EXISTS chk_link_status");
        } catch (\Throwable $e) {
        }
    }
};
