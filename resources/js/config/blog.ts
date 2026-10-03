export type BlogCardTheme = 'rose' | 'lavender' | 'yellow' | 'blue';

export const blogCardThemeClasses: Record<BlogCardTheme, string> = {
    rose: 'bg-[#f3dfe0]',
    lavender: 'bg-[#dfe3f4]',
    yellow: 'bg-[#efe8c6]',
    blue: 'bg-[#dfeaf0]',
};

const blogCardThemes = Object.keys(blogCardThemeClasses) as BlogCardTheme[];

export function blogCardThemeAt(index: number): BlogCardTheme {
    return blogCardThemes[index % blogCardThemes.length];
}

export const topicPillBackgroundClasses = [
    'bg-[#e8c7cc]',
    'bg-[#dfe2f1]',
    'bg-[#e9dcc8]',
    'bg-[#dfeaf2]',
    'bg-[#dfeadb]',
] as const;

export const latestWritingLayoutClasses = [
    'md:col-span-3 h-[55vh]',
    'md:col-span-2 h-[55vh]',
    'md:col-span-2 h-full max-h-[45vh]',
    'md:col-span-3 h-full max-h-[45vh]',
] as const;

export const newsletterFormClasses = {
    default: {
        form: 'mt-6 max-w-[460px]',
        label: 'mb-2 block text-sm font-semibold text-somi-plum-soft',
        fields: 'flex gap-2.5',
        input: 'min-w-0 flex-1 rounded-full border border-somi-line bg-somi-white px-[18px] py-[14px] text-sm text-somi-plum focus:outline-2 focus:outline-somi-blush-deep focus:outline-offset-2',
        button: 'inline-flex shrink-0 items-center gap-2 rounded-full bg-somi-plum px-7 py-[14px] text-sm font-medium text-somi-white transition-colors hover:bg-somi-rose disabled:cursor-not-allowed disabled:opacity-60',
    },
    signup: {
        form: 'mt-8 max-w-xl',
        label: 'mb-3 block text-[10px] font-semibold tracking-[0.25em] text-[#9e7c95] uppercase sm:text-xs',
        fields: 'flex items-center overflow-hidden rounded-full border border-[#d6b9b5] bg-[#f9f5f4] shadow-[0_1px_0_rgba(58,44,42,0.04)]',
        input: 'w-full min-w-0 bg-transparent px-5 py-4 text-base text-[#3a2c2a] placeholder:text-[#9a7b83] focus:outline-none',
        button: 'shrink-0 rounded-full bg-[#5f4054] px-6 py-3.5 text-sm font-medium text-white transition-colors hover:bg-[#4d2f43] disabled:cursor-not-allowed disabled:opacity-60',
    },
} as const;

export const archiveFilterClasses = {
    button: 'rounded-full border border-somi-line bg-somi-white px-[18px] py-2 text-sm text-somi-plum-soft transition-colors hover:bg-somi-plum hover:text-somi-white',
    selected: '!bg-somi-plum !text-somi-white',
} as const;

export const membershipPlanClasses = {
    card: 'rounded-somi-lg border border-somi-line bg-somi-white p-8',
    featuredCard: 'border-somi-plum! bg-somi-plum! text-somi-white!',
    button: 'w-full justify-center rounded-full bg-somi-plum px-7 py-3.5 text-center text-sm font-medium text-somi-white disabled:cursor-not-allowed',
    featuredButton: 'bg-somi-white! text-somi-plum! hover:bg-somi-blush!',
    description: 'text-somi-plum-soft',
    featuredDescription: 'text-somi-white',
} as const;

export const feedbackClasses = {
    success: 'text-green-700',
    error: 'text-somi-rose',
} as const;

export const sectionHeadingClasses = {
    eyebrow:
        'mb-3 text-xs font-semibold tracking-[0.14em] text-somi-rose uppercase',
    title: 'font-serif font-medium text-somi-plum',
    sizes: {
        compact: 'text-[clamp(1.6rem,2.6vw,2.2rem)]',
        large: 'text-3xl sm:text-4xl md:text-5xl',
    },
} as const;

export const subscriptionPlans = [
    {
        name: 'The Reader',
        price: '€0',
        cadence: 'forever',
        description:
            'Every published essay, delivered to your inbox as it goes live.',
        perks: [
            'Weekly essays by email',
            'Full access to the archive',
            'The topic newsletter',
        ],
        cta: 'Join for free',
        featured: false,
    },
    {
        name: 'The Inner Pages',
        price: '€6',
        cadence: '/ month',
        description:
            'For readers who want to go further — the unfinished thoughts, too.',
        perks: [
            'Everything in The Reader',
            'Members-only reflections',
            'Early access to new essays',
            'A say in what gets written next',
        ],
        cta: 'Become a member',
        featured: true,
    },
] as const;

export const blogNavigationClasses = {
    active: 'text-somi-plum',
    subscribeActive: 'bg-somi-rose',
} as const;
