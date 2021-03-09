<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksRequisitionBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_requisition_bill', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->json('requisition_prepared_by_manager');
            $table->integer('requisition_submitted_by_manager');
            $table->json('requisition_edited_by_cfo');
            $table->integer('requisition_approved_by_cfo');
            $table->json('requisition_edited_by_accountant');
            $table->integer('requisition_approved_by_accountant');
            $table->json('bill_prepared_by_resource');
            $table->integer('bill_submitted_by_resource');
            $table->json('bill_edited_by_manager');
            $table->integer('bill_approved_by_manager');
            $table->json('bill_edited_by_cfo');
            $table->integer('bill_approved_by_cfo');
            $table->json('bill_edited_by_accountant');
            $table->integer('bill_approved_by_accountant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_requisition_bill');
    }
}
