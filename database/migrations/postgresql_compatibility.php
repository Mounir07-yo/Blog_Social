<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * COMPATIBILITÉ POSTGRESQL POUR AREX
 * 
 * Cette migration adapte automatiquement les types MySQL vers PostgreSQL
 * Elle sera exécutée seulement sur PostgreSQL (Render)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Seulement si on est sur PostgreSQL
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // 1. Adapter la table reports : enum -> string avec check constraint
        if (Schema::hasTable('reports')) {
            Schema::table('reports', function (Blueprint $table) {
                // Remplacer enum par string avec contrainte
                $table->string('status')->default('pending')->change();
            });
            
            // Ajouter une contrainte PostgreSQL pour simuler l'enum
            DB::statement("ALTER TABLE reports ADD CONSTRAINT reports_status_check CHECK (status IN ('pending', 'reviewed', 'resolved', 'dismissed'))");
        }

        // 2. Adapter la table users : enum -> string avec check constraint  
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->default('active')->change();
            });
            
            // Ajouter contrainte pour le statut des utilisateurs
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('active', 'blocked', 'suspended'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // Supprimer les contraintes
        DB::statement("ALTER TABLE reports DROP CONSTRAINT IF EXISTS reports_status_check");
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
    }
};