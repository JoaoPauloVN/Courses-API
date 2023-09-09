<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Programming', 'Algorithms', 'Web Development', 'Software Engineering',
            'Artificial Intelligence', 'Machine Learning', 'Cybersecurity', 'Database Management',
            'Mobile App Development', 'Data Structures',
        
            // Arts and Humanities
            'Creative Writing', 'Visual Arts', 'Music', 'Film Production',
            'History', 'Philosophy', 'Literature', 'Theater',
            'Linguistics', 'Cultural Studies',
        
            // Business
            'Entrepreneurship', 'Marketing', 'Management', 'Finance',
            'Accounting', 'Project Management', 'Business Strategy', 'Sales',
            'Human Resources', 'Business Communication',
        
            // Data Science
            'Data Analysis', 'Machine Learning', 'Statistical Analysis', 'Data Visualization',
            'Big Data', 'Python Programming', 'R Programming', 'Data Cleaning',
            'Regression Analysis', 'Natural Language Processing',
        
            // Health
            'Nutrition', 'Exercise Science', 'Nursing', 'Public Health',
            'Medical Terminology', 'Healthcare Administration', 'Anatomy and Physiology', 'Mental Health',
            'First Aid/CPR', 'Wellness Coaching',
        
            // Information Technology
            'Network Administration', 'Systems Administration', 'Cloud Computing', 'IT Security',
            'Linux Administration', 'IT Support', 'Virtualization', 'DevOps',
            'Database Administration', 'IT Project Management',
        
            // Language Learning
            'English', 'Spanish', 'French', 'German',
            'Chinese', 'Japanese', 'Italian', 'Arabic',
            'Russian', 'Portuguese',
        
            // Math and Logic
            'Calculus', 'Algebra', 'Statistics', 'Geometry',
            'Probability', 'Number Theory', 'Logic', 'Discrete Mathematics',
            'Linear Algebra', 'Differential Equations',
        
            // Personal Development
            'Time Management', 'Leadership Skills', 'Communication Skills', 'Mindfulness',
            'Emotional Intelligence', 'Goal Setting', 'Public Speaking', 'Personal Finance',
            'Self-Care', 'Positive Psychology',
        
            // Physical Science and Engineering
            'Physics', 'Chemistry', 'Engineering Design', 'Mechanics',
            'Electrical Engineering', 'Materials Science', 'Thermodynamics', 'Civil Engineering',
            'Environmental Science', 'Robotics',
        
            // Social Sciences
            'Psychology', 'Sociology', 'Anthropology', 'Political Science',
            'Economics', 'Cultural Anthropology', 'Social Work', 'Gender Studies',
            'International Relations', 'Social Psychology'
        ];

        foreach(array_unique($skills) as $skill)
        {
            Skill::create([
                'name' => $skill
            ]);
        }
    }
}
