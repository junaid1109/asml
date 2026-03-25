<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TeamMember;
use App\Models\Page;
use App\Models\Setting;
use App\Models\HomeSection;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ams.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Team Members
        TeamMember::create([
            'name' => 'John Smith',
            'position' => 'CEO & Founder',
            'bio' => 'Visionary entrepreneur with 15+ years of experience in web design and development.',
            'email' => 'john@ams.com',
            'twitter' => 'https://twitter.com',
            'linkedin' => 'https://linkedin.com',
            'published' => true,
            'order' => 1,
        ]);

        TeamMember::create([
            'name' => 'Jane Doe',
            'position' => 'Lead Designer',
            'bio' => 'Creative designer passionate about creating beautiful user experiences.',
            'email' => 'jane@ams.com',
            'twitter' => 'https://twitter.com',
            'linkedin' => 'https://linkedin.com',
            'published' => true,
            'order' => 2,
        ]);

        TeamMember::create([
            'name' => 'Mike Johnson',
            'position' => 'Senior Developer',
            'bio' => 'Full-stack developer specializing in Laravel and modern JavaScript frameworks.',
            'email' => 'mike@ams.com',
            'twitter' => 'https://twitter.com',
            'linkedin' => 'https://linkedin.com',
            'published' => true,
            'order' => 3,
        ]);

        // Create Sample Pages
        Page::create([
            'title' => 'About Us',
            'slug' => 'about',
            'content' => '<p>Welcome to AMS! We are a team of passionate professionals dedicated to delivering exceptional web solutions. With over 10 years of experience, we have helped hundreds of businesses achieve their digital goals.</p><p>Our mission is to create innovative, scalable, and user-friendly web solutions that drive business growth.</p>',
            'page_type' => 'about',
            'published' => true,
        ]);

        Page::create([
            'title' => 'Terms and Conditions',
            'slug' => 'terms',
            'content' => '<p>These terms and conditions govern your use of this website and services provided by AMS.</p><p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>',
            'page_type' => 'terms',
            'published' => true,
        ]);

        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy',
            'content' => '<p>At AMS, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p><p>Please read this Privacy Policy carefully. If you do not agree with our policies and practices, please do not use our Services.</p>',
            'page_type' => 'privacy',
            'published' => true,
        ]);

        // Create Sample Settings
        Setting::create(['key' => 'site_name', 'value' => 'AMS']);
        Setting::create(['key' => 'site_tagline', 'value' => 'Professional Business Solutions']);
        Setting::create(['key' => 'site_email', 'value' => 'info@ams.com']);
        Setting::create(['key' => 'site_phone', 'value' => '+1 5589 55488 55']);
        Setting::create(['key' => 'site_address', 'value' => 'A108 Adam Street, New York, NY 535022, United States']);
        Setting::create(['key' => 'site_description', 'value' => 'Professional Business Solutions - Web Design, Development & Marketing']);

        // Call the Home Section Seeder
        $this->call(HomeSectionSeeder::class);
    }
}
