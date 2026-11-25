<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(414) 555-0188',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@forgeharbormetals.com'],
            [
                'name' => 'Elena Vargas',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(414) 555-0189',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'yard@forgeharbormetals.com'],
            [
                'name' => 'Marcus Hale',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(414) 555-0190',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'ForgeHarbor Metals',
            'company_phone' => '(414) 555-0188',
            'company_email' => 'hello@forgeharbormetals.com',
            'whatsapp' => '14145550188',
            'service_area' => 'Milwaukee, Racine, Kenosha & SE Wisconsin',
            'tax_rate' => '5.1',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => 'Bare Bright Copper', 'sku' => 'NF-CU-BB', 'category' => 'non_ferrous', 'unit_cost' => 3.10, 'unit_price' => 3.45, 'stock_qty' => 4200, 'unit' => 'lb'],
            ['name' => '#1 Copper', 'sku' => 'NF-CU-1', 'category' => 'non_ferrous', 'unit_cost' => 2.85, 'unit_price' => 3.15, 'stock_qty' => 6800, 'unit' => 'lb'],
            ['name' => 'Aluminum Extrusion', 'sku' => 'NF-AL-EX', 'category' => 'non_ferrous', 'unit_cost' => 0.55, 'unit_price' => 0.72, 'stock_qty' => 12500, 'unit' => 'lb'],
            ['name' => 'Yellow Brass', 'sku' => 'NF-BR-Y', 'category' => 'non_ferrous', 'unit_cost' => 1.85, 'unit_price' => 2.10, 'stock_qty' => 3100, 'unit' => 'lb'],
            ['name' => 'HMS #1 Steel', 'sku' => 'FE-HMS-1', 'category' => 'ferrous', 'unit_cost' => 180, 'unit_price' => 210, 'stock_qty' => 240, 'unit' => 'ton'],
            ['name' => 'Plate & Structural', 'sku' => 'FE-PS-1', 'category' => 'ferrous', 'unit_cost' => 195, 'unit_price' => 230, 'stock_qty' => 85, 'unit' => 'ton'],
            ['name' => 'Stainless 304', 'sku' => 'NF-SS-304', 'category' => 'non_ferrous', 'unit_cost' => 0.42, 'unit_price' => 0.55, 'stock_qty' => 5400, 'unit' => 'lb'],
            ['name' => 'Catalytic Converter Unit', 'sku' => 'CAT-GEN-1', 'category' => 'converter', 'unit_cost' => 85, 'unit_price' => 120, 'stock_qty' => 64, 'unit' => 'each'],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['is_active' => true]);
        }

        $customers = collect([
            ['name' => 'Derek Novak', 'email' => 'derek@lakefabwi.com', 'phone' => '(414) 555-2201', 'company' => 'Lake Fab WI', 'city' => 'Milwaukee', 'state' => 'WI', 'zip' => '53204', 'address' => '1220 S 1st St'],
            ['name' => 'Priya Menon', 'email' => 'ops@bayviewhvac.com', 'phone' => '(414) 555-2210', 'company' => 'Bay View HVAC', 'city' => 'Milwaukee', 'state' => 'WI', 'zip' => '53207', 'address' => '2890 S Kinnickinnic Ave'],
            ['name' => 'Tom Richter', 'email' => 'tom@richtersdemo.com', 'phone' => '(262) 555-2299', 'company' => 'Richter Demo', 'city' => 'Racine', 'state' => 'WI', 'zip' => '53403', 'address' => '900 6th St'],
            ['name' => 'Aisha Cole', 'email' => 'aisha@harborstamp.com', 'phone' => '(414) 555-2188', 'company' => 'Harbor Stamp Works', 'city' => 'Cudahy', 'state' => 'WI', 'zip' => '53110', 'address' => '3700 E Layton Ave'],
            ['name' => 'Noah Berg', 'email' => 'noah@kenoshawire.com', 'phone' => '(262) 555-2177', 'company' => 'Kenosha Wire Recovery', 'city' => 'Kenosha', 'state' => 'WI', 'zip' => '53140', 'address' => '5600 52nd St'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = [
            ['customer' => 0, 'title' => 'Weekly shop aluminum + steel', 'service_type' => 'industrial', 'status' => 'scheduled', 'sq_ft' => 4, 'quoted_amount' => 4200],
            ['customer' => 1, 'title' => 'HVAC copper & aluminum drop', 'service_type' => 'non_ferrous', 'status' => 'in_progress', 'sq_ft' => 1, 'quoted_amount' => 2850],
            ['customer' => 2, 'title' => 'Warehouse demo HMS haul', 'service_type' => 'ferrous', 'status' => 'quoted', 'sq_ft' => 18, 'quoted_amount' => 9600],
            ['customer' => 3, 'title' => 'Stamping plant container swap', 'service_type' => 'container', 'status' => 'completed', 'sq_ft' => 6, 'quoted_amount' => 5400, 'final_amount' => 5620],
            ['customer' => 4, 'title' => 'Insulated wire buy ticket', 'service_type' => 'non_ferrous', 'status' => 'invoiced', 'sq_ft' => 2, 'quoted_amount' => 3100, 'final_amount' => 3185],
        ];

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'SM-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo buy/haul for ForgeHarbor Metals. sq_ft stores estimated tons for ferrous or container count.',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.051, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * 1.051, 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * 1.051, 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'ach',
                        'notes' => 'Demo settlement',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Container swap — Lake Fab'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'pickup',
                'starts_at' => now()->addDays(2)->setTime(8, 0),
                'ends_at' => now()->addDays(2)->setTime(9, 30),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Demo site weigh-in — Richter'],
            [
                'customer_id' => $customers[2]->id,
                'project_id' => $projectModels[2]->id,
                'type' => 'site_visit',
                'starts_at' => now()->addDays(4)->setTime(10, 0),
                'ends_at' => now()->addDays(4)->setTime(11, 30),
                'status' => 'confirmed',
                'location' => $customers[2]->address,
            ]
        );

        $posts = [
            [
                'title' => 'How Bare Bright Copper Earns More Than Insulated Wire',
                'excerpt' => 'Sorting and stripping before you hit the scale protects your Milwaukee non-ferrous ticket.',
                'cover' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1400&q=80',
                'body' => "HVAC and electrical crews often mix bare bright with insulated or painted copper. That blend forces a lower average grade.\n\nForgeHarbor pays posted board prices for clean bare bright and #1 copper. Bring stripped wire separately, keep oil and plastic out of the load, and ask the scale house for today’s differential before you leave the shop.",
            ],
            [
                'title' => 'Preparing HMS Loads Without Hidden Contamination',
                'excerpt' => 'Dirt, freon appliances, and concrete in steel piles trigger deductions — and slow the truck.',
                'cover' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1400&q=80',
                'body' => "Demolition steel looks ready until graders find sealed tanks, tires, or freezers still charged with refrigerant.\n\nWe photograph every ferrous load and note contamination on the ticket. Pre-sort freezers, remove non-metallics, and call ahead for oversize plate so the Milwaukee yard can stage the shear.",
            ],
            [
                'title' => 'When a Shop Should Switch to Scheduled Containers',
                'excerpt' => 'If scrap piles grow faster than your pickup truck, a gaylord or roll-off contract pays for itself.',
                'cover' => 'https://images.unsplash.com/photo-1565793298595-6a879b1d9492?auto=format&fit=crop&w=1400&q=80',
                'body' => "Machine shops and stampers lose floor space when chips and offcuts wait for a weekend haul.\n\nForgeHarbor stages containers, swaps on your production rhythm, and reconciles weights to your account in ERP. Ask for a two-week pilot if you are generating more than a pickup-bed of metal each week.",
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = [
            ['category' => 'issues', 'title' => 'Ticket lower than expected after grading', 'body' => "1. Compare printed grade notes to what you loaded.\n2. Check for insulation, dirt, oil, or mixed metals.\n3. Ask the grader to show contamination photos.\n4. Re-sort remaining material before the next drop."],
            ['category' => 'issues', 'title' => 'Container not swapped on schedule', 'body' => "Confirm the generator account and dock access hours. Verify the ERP appointment status. If the yard truck was delayed, reschedule and note surge volume so the next swap brings an extra empty."],
            ['category' => 'guides', 'title' => 'Walk-up scale house checklist', 'body' => "Bring government ID, separate non-ferrous from ferrous, remove sealed tanks, and know approximate weights. Stay in the vehicle until directed onto the scale. Keep the printed ticket for your records."],
            ['category' => 'guides', 'title' => 'How industrial accounts set up containers', 'body' => "Share weekly scrap volume by grade, dock constraints, and preferred swap days. We stage gaylords or roll-offs, assign a generator ID, and reconcile weights in ERP with monthly statements."],
            ['category' => 'admin', 'title' => 'Admin ERP quick start', 'body' => "Login at /admin with admin@example.com / password.\n1. Add customers in CRM.\n2. Create a buy/haul Project with estimated tons and quote.\n3. Schedule pickups and site visits.\n4. Convert completed jobs to invoices and record payments.\n5. Use AI Studio for blog drafts and troubleshooting.\n6. Update company Settings for phone, WhatsApp, and tax rate."],
            ['category' => 'admin', 'title' => 'Roles: Admin, Manager, Staff', 'body' => "Admin: full ERP + settings + users.\nManager: buys, inventory, invoices, scheduling.\nStaff: yard-facing records and appointment updates.\nAssign roles on the Users resource."],
            ['category' => 'troubleshoot', 'title' => 'Inventory lot weight does not match tickets', 'body' => "Sum related buy tickets vs product stock adjustments. Confirm unit (lb vs ton). Re-weigh a sample lot, then correct stock_qty and add a note on the Project."],
            ['category' => 'troubleshoot', 'title' => 'Chatbot giving demo answers only', 'body' => "Demo mode is expected without API keys. Add OPENAI_API_KEY or GEMINI_API_KEY to .env, then clear config cache. The public chatbot and AI Studio will prefer live models when keys are present."],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}