<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hero stats
        $heroStats = json_encode([
            ['number' => '500+', 'label' => 'Successful Projects'],
            ['number' => '98%', 'label' => 'Client Satisfaction'],
            ['number' => '10+', 'label' => 'Years Experience'],
        ]);

        // About stats
        $aboutStats = json_encode([
            ['number' => '15', 'label' => 'Years Experience'],
            ['number' => '850', 'label' => 'Projects Completed'],
            ['number' => '240', 'label' => 'Happy Clients'],
        ]);

        $sections = [
            [
                'section_name' => 'hero',
                'title' => 'Transform Your Business Vision Into Reality',
                'subtitle' => 'We create innovative solutions that help businesses grow',
                'description' => 'We create innovative solutions that help businesses grow. Our expertise spans web design, development, and digital marketing.',
                'button_text' => 'Get Started Today',
                'button_link' => '/',
                'content' => $heroStats,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'section_name' => 'about',
                'title' => 'Crafting Excellence Through Innovation and Dedication',
                'subtitle' => 'Professional Services',
                'description' => 'We are passionate professionals committed to delivering exceptional results that exceed expectations and drive meaningful transformation.',
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'content' => $aboutStats,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'section_name' => 'clients',
                'title' => 'Our Clients',
                'subtitle' => 'Trusted By',
                'description' => 'We are proud to work with leading companies and organizations around the world.',
                'display_order' => 3,
                'is_active' => true,
                'content' => json_encode([]), // Empty array - will be populated via admin
            ],
            [
                'section_name' => 'services',
                'title' => 'What We Do Offer',
                'subtitle' => 'Services',
                'description' => 'Check our professional services designed for your business success.',
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'section_name' => 'why-us',
                'title' => 'Why Choose Us',
                'subtitle' => 'Why Us',
                'description' => 'We deliver exceptional results through proven expertise, cutting-edge innovation, and unwavering commitment to your success.',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'section_name' => 'team',
                'title' => 'Meet Our Team',
                'subtitle' => 'Our Professional Team',
                'description' => 'We are a talented team of professionals dedicated to delivering exceptional results and transforming your business vision into reality.',
                'display_order' => 6,
                'is_active' => true,
            ],
            [
                'section_name' => 'work-process',
                'title' => 'Work Process',
                'description' => 'Our proven approach to delivering exceptional results',
                'content' => json_encode([
                    [
                        'number' => '01',
                        'title' => 'Research & Analysis',
                        'description' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione.',
                        'features' => [
                            ['icon' => 'bi-check-circle', 'text' => 'Market Research'],
                            ['icon' => 'bi-check-circle', 'text' => 'Data Analysis'],
                            ['icon' => 'bi-check-circle', 'text' => 'User Feedback'],
                        ],
                        'image' => 'assets/img/steps/steps-1.webp'
                    ],
                    [
                        'number' => '02',
                        'title' => 'Design & Planning',
                        'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur.',
                        'features' => [
                            ['icon' => 'bi-check-circle', 'text' => 'Wireframing'],
                            ['icon' => 'bi-check-circle', 'text' => 'UI/UX Design'],
                            ['icon' => 'bi-check-circle', 'text' => 'Prototyping'],
                        ],
                        'image' => 'assets/img/steps/steps-2.webp'
                    ],
                    [
                        'number' => '03',
                        'title' => 'Development & Launch',
                        'description' => 'Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil.',
                        'features' => [
                            ['icon' => 'bi-check-circle', 'text' => 'Development'],
                            ['icon' => 'bi-check-circle', 'text' => 'Testing'],
                            ['icon' => 'bi-check-circle', 'text' => 'Deployment'],
                        ],
                        'image' => 'assets/img/steps/steps-3.webp'
                    ]
                ]),
                'display_order' => 7.5,
                'is_active' => true,
            ],
            [
                'section_name' => 'testimonials',
                'title' => 'What They Say',
                'subtitle' => 'Testimonials',
                'description' => 'Hear from our satisfied clients and partners.',
                'display_order' => 8,
                'is_active' => true,
            ],
            [
                'section_name' => 'portfolio',
                'title' => 'Our Recent Projects',
                'subtitle' => 'Portfolio',
                'description' => 'Explore our latest work and see how we transform ideas into successful outcomes.',
                'display_order' => 9,
                'is_active' => true,
                'content' => json_encode([]),
            ],
            [
                'section_name' => 'portfolio-conclusion',
                'title' => 'Ready to Start Your Project?',
                'subtitle' => 'Let\'s Bring Your Ideas to Life',
                'description' => 'Contact us today and let\'s discuss how we can help your business grow and succeed.',
                'button_text' => 'Contact Us',
                'button_link' => '/contact',
                'display_order' => 10,
                'is_active' => true,
            ],
            [
                'section_name' => 'call-to-action',
                'title' => 'Ready to Transform Your Business?',
                'subtitle' => 'Let\'s Work Together',
                'description' => 'Connect with us today and discover how our solutions can help you achieve your goals. Our team is ready to support your success.',
                'button_text' => 'Get In Touch',
                'button_link' => '/contact',
                'display_order' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::firstOrCreate(
                ['section_name' => $section['section_name']],
                $section
            );
        }
    }
}
