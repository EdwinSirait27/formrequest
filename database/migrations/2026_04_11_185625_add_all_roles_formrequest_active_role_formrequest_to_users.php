<?php    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
          Schema::connection('hrx')->table('users', function (Blueprint $table) {
    $table->string('active_role_formrequest')->nullable()->after('password');
     $table->json('all_roles_formrequest')->nullable()->after('active_role_formrequest');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
