<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@task.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $member = User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@task.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        // Sample Projects
        $p1 = \App\Models\Project::create([
            'name' => 'Enterprise CRM',
            'description' => 'Development of a high-performance CRM system for internal use.',
            'manager_id' => $admin->id
        ]);

        $p2 = Project::create([
            'name' => 'Mobile App Revamp',
            'description' => 'Modernizing the existing mobile application with a glassmorphic design.',
            'manager_id' => $member->id
        ]);

        // Sample Tasks
        Task::create([
            'title' => 'Design System Implementation',
            'description' => 'Define colors, typography and glassmorphic components.',
            'project_id' => $p1->id,
            'assigned_to' => $admin->id,
            'due_date' => now()->addDays(7),
            'status' => 'pending',
            'priority' => 'high',
            'creator_id' => $admin->id,
        ]);

        Task::create([
            'title' => 'API Integration',
            'description' => 'Connect the frontend with the backend REST APIs.',
            'project_id' => $p1->id,
            'assigned_to' => $member->id,
            'due_date' => now()->addDays(14),
            'status' => 'pending',
            'priority' => 'medium',
            'creator_id' => $admin->id,
        ]);

        Task::create([
            'title' => 'User Authentication',
            'description' => 'Implement secure login and registration flow.',
            'project_id' => $p2->id,
            'assigned_to' => $admin->id,
            'due_date' => now()->subDays(2),
            'status' => 'completed',
            'priority' => 'high',
            'creator_id' => $admin->id,
        ]);
    }
}
