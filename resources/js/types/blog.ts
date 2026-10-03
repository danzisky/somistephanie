export interface BlogArticleSummary {
    id: string;
    slug: string;
    title: string;
    standfirst: string;
    author: string;
    category: string | null;
    category_slug: string | null;
    date: string | null;
    date_formatted: string | null;
    read_time: number;
    views: number;
    track_views: boolean;
    comments_count: number;
    show_comments_count: boolean;
    featured: boolean;
    hero_image: string | null;
    hero_image_caption: string | null;
}

export interface BlogArticle extends BlogArticleSummary {
    content_html: string;
}

export interface BlogTopic {
    title: string;
    slug: string;
    description: string;
}

export interface BlogComment {
    id: string;
    name: string;
    comment: string;
    date: string;
}
