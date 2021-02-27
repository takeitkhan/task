<?php

use Tritiyo\Task\Controllers\TaskController;
use Tritiyo\Task\Controllers\TaskSiteController;
use Tritiyo\Task\Controllers\TaskVehicleController;
use Tritiyo\Task\Controllers\TaskMaterialController;
use Tritiyo\Task\Controllers\TaskProofController;
use Tritiyo\Task\Controllers\TaskStatusController;

Route::group(['middleware' => ['web', 'role:1,2,3,8']], function () {
    //TaskStatus
    Route::resources([
        'taskstatus' => TaskStatusController::class,
    ]);
});

Route::group(['middleware' => ['web', 'role:1,2,3,8']], function () {
    Route::any('tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::resources([
        'tasks' => TaskController::class,
    ]);
});

Route::group(['middleware' => ['web', 'role:1,3,8']], function () {
    Route::resources([
        'tasksites' => TaskSiteController::class,
    ]);

    Route::get('tasks/sites/{id}', [TaskSiteController::class, 'taskSitebyTaskId'])->name('tasks.site.edit');

    //Vehicle
    Route::resources([
        'taskvehicle' => TaskVehicleController::class,
    ]);

    //Vehicle
    Route::resources([
        'taskmaterial' => TaskMaterialController::class,
    ]);

});

Route::group(['middleware' => ['web', 'role:2']], function () {
    //TaskProof
    Route::resources([
        'taskproof' => TaskProofController::class,
    ]);
});
