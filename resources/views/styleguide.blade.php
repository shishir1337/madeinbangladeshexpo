@php
    $swatches = [
        ['Jute cream', 'bg-cream', '#FBF7EE', 'Surface'],
        ['Cream 2', 'bg-cream-2', '#F4EDDD', 'Alternate surface'],
        ['Sand', 'bg-sand', '#E6DCC6', 'Borders'],
        ['Ink', 'bg-ink', '#1F2A44', 'Body text'],
        ['Brazil navy', 'bg-navy', '#002776', 'Headings, links'],
        ['Bottle green', 'bg-green', '#004F3A', 'Primary action'],
        ['Ipê yellow', 'bg-yellow', '#FFDF00', 'Highlight fills only'],
        ['Crimson', 'bg-crimson', '#B3122A', 'Live, alerts'],
        ['Midnight', 'bg-midnight', '#071A33', 'Dark sections'],
        ['Mint', 'bg-mint', '#3DDC97', 'Accents on dark'],
    ];

    $breadcrumbs = [
        ['label' => 'Home', 'url' => url('/')],
        ['label' => 'Style guide', 'url' => null],
    ];

    $facts = [
        ['icon' => 'calendar', 'label' => 'Dates', 'value' => '22–25 March 2027'],
        ['icon' => 'map-pin', 'label' => 'Venue', 'value' => 'Pro Magno, São Paulo'],
        ['icon' => 'store', 'label' => 'Stall', 'value' => 'US$4,000 (8 × 8 ft)'],
        ['icon' => 'arrow-right', 'label' => 'Next step', 'value' => 'Apply online'],
    ];

    $steps = [
        ['title' => 'You apply online', 'body' => 'Company details, sector and products.', 'who' => 'You'],
        ['title' => 'You upload documents', 'body' => 'Trade licence, TIN, VAT and export registration.', 'who' => 'You'],
        ['title' => 'BBCCI reviews', 'body' => 'Usually within five working days.', 'who' => 'BBCCI', 'whoTone' => 'navy'],
        ['title' => 'Invoice and contract', 'body' => 'Issued in your language.', 'who' => 'BBCCI', 'whoTone' => 'navy'],
        ['title' => 'You pay', 'body' => 'In taka or US dollars.', 'who' => 'You'],
    ];
@endphp

<x-layouts.site title="Style guide · Made in Bangladesh Expo">
    <x-ui.page-hero
        eyebrow="Design system"
        title="Style guide"
        lead="Every component of the Made in Bangladesh Expo site, in each tone. Pages are assembled from these parts, never invented."
        image="expo25-stand-garments"
        image-alt="Visitors at a garments stand at the 2025 expo"
        :breadcrumbs="$breadcrumbs"
    >
        <x-slot:actions>
            <x-ui.button href="#components" icon="arrow-right">Components</x-ui.button>
            <x-ui.button href="#heroes" variant="secondary">Hero types</x-ui.button>
        </x-slot:actions>
        <x-slot:facts>
            <x-ui.facts :items="$facts" />
        </x-slot:facts>
    </x-ui.page-hero>

    <x-ui.section tone="white" id="components">
        <x-ui.heading eyebrow="Tokens" title="Colour" lead="Contrast-checked. Yellow is a fill, always with navy text; flag colours are never text on white." />
        <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            @foreach ($swatches as [$name, $class, $hex, $role])
                <div class="overflow-hidden rounded-2xl ring-1 ring-ink/10">
                    <div class="{{ $class }} h-24"></div>
                    <div class="p-3">
                        <p class="font-semibold text-navy">{{ $name }}</p>
                        <p class="font-mono text-xs text-ink-soft">{{ $hex }}</p>
                        <p class="mt-1 text-xs text-ink-soft">{{ $role }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-ui.section>

    <x-ui.section>
        <x-ui.heading eyebrow="Tokens" title="Typography" lead="Anek Bangla for display in all three languages; Inter for Latin body; Noto Sans Bengali for Bangla body." />
        <div class="mt-10 space-y-6">
            <p class="font-display text-display-2xl font-semibold text-navy">Made in Bangladesh</p>
            <p class="font-display text-display-xl font-semibold text-navy">Meet buyers in São Paulo</p>
            <p class="font-display text-display-lg font-semibold text-navy" lang="bn">মেইড ইন বাংলাদেশ এক্সপো ২০২৬</p>
            <p class="font-display text-display-md font-semibold text-navy" lang="pt-BR">Fabricantes de Bangladesh encontram compradores do Brasil</p>
            <p class="max-w-2xl text-lead text-ink-soft">A lead paragraph sets up the section in one or two sentences, at a comfortable measure.</p>
            <p class="max-w-2xl text-ink" lang="bn">বাংলাদেশের উৎপাদকেরা সাও পাওলোতে ব্রাজিল ও লাতিন আমেরিকার ক্রেতাদের সঙ্গে সরাসরি দেখা করেন। ক্রেতাদের নিবন্ধন বিনামূল্যে।</p>
        </div>
    </x-ui.section>

    <x-ui.section tone="white">
        <x-ui.heading eyebrow="Actions" title="Buttons, links and chips" />
        <div class="mt-10 flex flex-wrap items-center gap-3">
            <x-ui.button icon="arrow-right">Apply to exhibit</x-ui.button>
            <x-ui.button variant="secondary">Register</x-ui.button>
            <x-ui.button variant="highlight" icon="ticket">Get your free pass</x-ui.button>
            <x-ui.button variant="ghost" icon-start="download">Download brochure</x-ui.button>
            <x-ui.button size="sm">Small</x-ui.button>
            <x-ui.button size="lg" icon="arrow-right">Large</x-ui.button>
        </div>
        <div class="mt-8 flex flex-wrap items-center gap-6">
            <x-ui.link href="#">Read the exhibitor guide</x-ui.link>
            <x-ui.chip tone="green" icon="check">Confirmed</x-ui.chip>
            <x-ui.chip tone="navy">BBCCI's move</x-ui.chip>
            <x-ui.chip tone="yellow">Early bird</x-ui.chip>
            <x-ui.chip tone="crimson" icon="clock">Closes soon</x-ui.chip>
            <x-ui.chip>Neutral</x-ui.chip>
        </div>
    </x-ui.section>

    <x-ui.section tone="midnight">
        <x-ui.heading eyebrow="On dark" title="Stats tell the trade story" lead="Every figure carries a source and a date. Values count up once, in the page's own digits." />
        <div class="mt-12 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            <x-ui.stat :value="215" prefix="US$" suffix="m" label="Bangladesh's exports to Brazil, FY2025-26" source="EPB, July 2026" />
            <x-ui.stat :value="10.2" :decimals="1" suffix="%" label="Share of Brazil's clothing imports from Bangladesh" source="ComexStat, 2025" />
            <x-ui.stat :value="213" suffix="m" label="Consumers in Brazil" source="World Bank, 2024" />
            <x-ui.stat :value="29" label="Days by sea, Chattogram to Santos" source="BBCCI, 2026" />
        </div>
        <div class="mt-12 flex flex-wrap gap-3">
            <x-ui.button variant="highlight">Highlight</x-ui.button>
            <x-ui.button variant="on-dark">On dark</x-ui.button>
            <x-ui.button variant="light">Light</x-ui.button>
            <x-ui.chip tone="dark" icon="sparkles">Chip on dark</x-ui.chip>
        </div>
    </x-ui.section>

    <x-ui.section>
        <x-ui.heading eyebrow="Containers" title="Cards and notices" />
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <x-ui.card href="#">
                <span class="grid size-12 place-items-center rounded-xl bg-green-50 text-green"><x-ui.icon name="shirt" class="size-6" /></span>
                <p class="mt-5 font-display text-xl font-semibold text-navy">Garments</p>
                <p class="mt-2 text-ink-soft">Brazil's second-largest clothing supplier, every year since 2018.</p>
                <p class="mt-5"><x-ui.chip tone="green">US$240m</x-ui.chip></p>
            </x-ui.card>
            <x-ui.card tone="cream">
                <p class="eyebrow">Cream card</p>
                <p class="mt-3 text-ink-soft">For secondary content that sits on white sections.</p>
            </x-ui.card>
            <x-ui.card tone="midnight">
                <p class="eyebrow !text-mint">Midnight card</p>
                <p class="mt-3 text-white/80">For a highlight inside a light section.</p>
            </x-ui.card>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            <x-ui.notice title="Bank details are never shown on the public site">You receive them on your invoice and in your portal, to protect you from payment fraud.</x-ui.notice>
            <x-ui.notice tone="success" title="Application received">Your application number is MBE-2026-0042.</x-ui.notice>
            <x-ui.notice tone="warning" title="Passport validity">Your passport must be valid for six months after the expo.</x-ui.notice>
            <x-ui.notice tone="danger" title="Unregistered medicines cannot be exhibited">ANVISA registration and a local holder are required.</x-ui.notice>
        </div>
    </x-ui.section>

    <x-ui.section tone="white">
        <x-ui.heading eyebrow="Disclosure" title="Tabs and accordion" lead="Tabs follow the ARIA pattern with arrow keys. The accordion is native, so it works without JavaScript." />
        <div class="mt-10 grid gap-12 lg:grid-cols-2">
            <x-ui.tabs id="styleguide-tabs" label="Audiences" :tabs="['exhibitors' => 'Exhibitors', 'buyers' => 'Buyers', 'delegates' => 'Delegates']">
                <x-ui.tab name="exhibitors"><p class="text-ink-soft">A stall puts your products in front of importers, wholesalers and retailers from Brazil and Latin America.</p></x-ui.tab>
                <x-ui.tab name="buyers"><p class="text-ink-soft">Registered buyers enter free and can book meetings with exhibitors before the expo.</p></x-ui.tab>
                <x-ui.tab name="delegates"><p class="text-ink-soft">Business delegates join the Bangladesh delegation and B2B matchmaking without a stall.</p></x-ui.tab>
            </x-ui.tabs>
            <x-ui.accordion name="styleguide-faq">
                <x-ui.accordion-item title="Is entry free for buyers?" open>Yes. Trade buyers who pre-register get a free pass with full access.</x-ui.accordion-item>
                <x-ui.accordion-item title="Can I sell my samples at the expo?">Goods to be sold need a regular import. Samples for display enter under temporary admission.</x-ui.accordion-item>
                <x-ui.accordion-item title="Do I need a visa?">Bangladeshi citizens need a business visa (VIVIS). Allow at least two months.</x-ui.accordion-item>
            </x-ui.accordion>
        </div>
    </x-ui.section>

    <x-ui.section>
        <x-ui.heading eyebrow="Process" title="Steps: whose move is it?" />
        <x-ui.steps :items="$steps" class="mt-12" />
    </x-ui.section>

    <div id="heroes">
        <x-ui.page-hero variant="photo" eyebrow="Photo hero" title="Take your products to Brazil" lead="Full-bleed photography for landing pages." image="expo25-welcome" image-alt="The welcome gate of the 2025 expo" focus="center 35%">
            <x-slot:actions>
                <x-ui.button variant="highlight" icon="arrow-right">Apply to exhibit</x-ui.button>
                <x-ui.button variant="on-dark">Stall packages</x-ui.button>
            </x-slot:actions>
            <x-slot:facts>
                <x-ui.facts :items="$facts" />
            </x-slot:facts>
        </x-ui.page-hero>

        <x-ui.page-hero variant="dark" eyebrow="Dark hero" title="Travel & visa" lead="For utility pages: visas, health, money and practical tips." :breadcrumbs="$breadcrumbs" />
    </div>

    <x-ui.section tone="sand">
        <x-ui.heading eyebrow="Brand" title="Motif" lead="Jamdani weaving crossed with Brazilian modernist tilework. Never a literal flag." />
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <div class="h-48 overflow-hidden rounded-3xl bg-white text-green ring-1 ring-sand"><x-ui.motif variant="jamdani" /></div>
            <div class="h-48 overflow-hidden rounded-3xl bg-midnight" style="--motif-1: #3ddc97; --motif-2: #ffdf00; --motif-3: #b3122a"><x-ui.motif variant="tiles" /></div>
            <div class="flex h-48 flex-col justify-end overflow-hidden rounded-3xl bg-green text-yellow"><x-ui.motif variant="band" class="h-6" style="--motif-bg: #004f3a" /></div>
        </div>
    </x-ui.section>
</x-layouts.site>
