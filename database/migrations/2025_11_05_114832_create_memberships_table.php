<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\MembershipsAccessTypeEnum;
use App\Enums\MembershipsDurationTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // 'gym', 'group', 'all' (Тільки зал, тільки групові, все разом)
            $table->enum('access_type', MembershipsAccessTypeEnum::allValues());

            // 'unlimited' (безліміт), 'visits' (на к-ть відвідувань)
            $table->enum('duration_type', MembershipsDurationTypeEnum::allValues());

            // Для 'unlimited': к-ть днів. 1 міс = 30, 6 міс = 180
            $table->integer('duration_days')->nullable();

            // Для 'visits': к-ть візитів. Наприклад, 8 або 12
            $table->integer('visit_limit')->nullable();

            // Ціна в копійках, щоб уникнути проблем з float
            $table->decimal('price', 10, 2);

            // Чи доступний цей план для купівлі
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
