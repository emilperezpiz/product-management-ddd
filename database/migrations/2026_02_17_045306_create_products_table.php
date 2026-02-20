<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->uuid('uuid')->primary()->unique();
            $table->string('sku')->unique();
            $table->string('name', 50);
            $table->string('description', 150)->nullable();
            $table->decimal('price', 12, 2);
            $table->string('category', 25);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('imagePath')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
