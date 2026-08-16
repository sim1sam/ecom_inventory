@extends('frontend.layouts.app')

@section('title', $blog->title . ' - Blog')
@section('meta_description', $blog->short_description ?? Str::limit(strip_tags($blog->description), 160))
@section('meta_keywords', 'jewellery blog, ' . $blog->title)

@push('styles')
<style>
.blog-detail-hero {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 60px 0 40px;
}

.blog-detail-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    margin-top: -30px;
    position: relative;
    z-index: 2;
}

.blog-featured-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

.blog-content {
    padding: 40px;
}

.blog-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    line-height: 1.3;
}

.blog-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
    font-size: 0.95rem;
    color: #6c757d;
}

.blog-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.blog-description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
    margin-bottom: 40px;
}

.blog-description h1,
.blog-description h2,
.blog-description h3,
.blog-description h4,
.blog-description h5,
.blog-description h6 {
    color: #2c3e50;
    margin-top: 30px;
    margin-bottom: 15px;
}

.blog-description p {
    margin-bottom: 20px;
}

.blog-description img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 20px 0;
}

.blog-description blockquote {
    background: #f8f9fa;
    border-left: 4px solid var(--primary-color, #d4af37);
    padding: 20px;
    margin: 30px 0;
    border-radius: 0 10px 10px 0;
    font-style: italic;
}

.blog-description ul,
.blog-description ol {
    padding-left: 30px;
    margin-bottom: 20px;
}

.blog-description li {
    margin-bottom: 8px;
}

.sidebar {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 30px;
    height: fit-content;
    position: sticky;
    top: 100px;
}

.sidebar-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--primary-color, #d4af37);
}

.recent-blog-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #dee2e6;
}

.recent-blog-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.recent-blog-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    flex-shrink: 0;
}

.recent-blog-content {
    flex: 1;
}

.recent-blog-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    line-height: 1.4;
}

.recent-blog-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.recent-blog-title a:hover {
    color: var(--primary-color, #d4af37);
}

.recent-blog-date {
    font-size: 0.85rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 5px;
}

.back-to-blog {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary-color, #d4af37);
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 20px;
    transition: color 0.3s ease;
}

.back-to-blog:hover {
    color: #b8941f;
}

.share-buttons {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.share-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
}

.share-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.share-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.share-facebook {
    background: #1877f2;
    color: white;
}

.share-twitter {
    background: #1da1f2;
    color: white;
}

.share-linkedin {
    background: #0077b5;
    color: white;
}

.share-whatsapp {
    background: #25d366;
    color: white;
}

.share-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}

@media (max-width: 768px) {
    .blog-detail-hero {
        padding: 40px 0 20px;
    }
    
    .blog-featured-image {
        height: 250px;
    }
    
    .blog-content {
        padding: 30px 20px;
    }
    
    .blog-title {
        font-size: 2rem;
    }
    
    .blog-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .sidebar {
        margin-top: 40px;
        position: static;
    }
    
    .share-links {
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<!-- Blog Detail Hero -->
<section class="blog-detail-hero">
    <div class="container">
        <a href="{{ route('blog') }}" class="back-to-blog">
            <i class="fas fa-arrow-left"></i>
            Back to Blog
        </a>
    </div>
</section>

<!-- Blog Detail Content -->
<section class="pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="blog-detail-container">
                    @if($blog->image)
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-featured-image">
                    @endif
                    
                    <div class="blog-content">
                        <h1 class="blog-title">{{ $blog->title }}</h1>
                        
                        <div class="blog-meta">
                            <div class="blog-meta-item">
                                <i class="far fa-calendar-alt"></i>
                                <span>{{ $blog->created_at->format('F d, Y') }}</span>
                            </div>
                            @if($blog->category)
                                <div class="blog-meta-item">
                                    <i class="fas fa-folder"></i>
                                    <span>{{ $blog->category->name }}</span>
                                </div>
                            @endif
                            <div class="blog-meta-item">
                                <i class="far fa-clock"></i>
                                <span>{{ ceil(str_word_count(strip_tags($blog->description)) / 200) }} min read</span>
                            </div>
                        </div>
                        
                        @if($blog->short_description)
                            <div class="lead mb-4" style="color: #6c757d; font-size: 1.2rem; line-height: 1.6;">
                                {{ $blog->short_description }}
                            </div>
                        @endif
                        
                        <div class="blog-description">
                            {!! $blog->description !!}
                        </div>
                        
                        <!-- Share Buttons -->
                        <div class="share-buttons">
                            <h4 class="share-title">Share this article</h4>
                            <div class="share-links">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="share-link share-facebook">
                                    <i class="fab fa-facebook-f"></i>
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                                   target="_blank" class="share-link share-twitter">
                                    <i class="fab fa-twitter"></i>
                                    Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="share-link share-linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                    LinkedIn
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" 
                                   target="_blank" class="share-link share-whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="sidebar">
                    @if($recentBlogs->count() > 0)
                        <h3 class="sidebar-title">Recent Posts</h3>
                        @foreach($recentBlogs as $recentBlog)
                            <div class="recent-blog-item">
                                @if($recentBlog->image)
                                    <img src="{{ asset($recentBlog->image) }}" alt="{{ $recentBlog->title }}" class="recent-blog-image">
                                @else
                                    <div class="recent-blog-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="recent-blog-content">
                                    <h4 class="recent-blog-title">
                                        <a href="{{ route('blog.detail', $recentBlog->slug) }}">{{ Str::limit($recentBlog->title, 60) }}</a>
                                    </h4>
                                    <div class="recent-blog-date">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $recentBlog->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for back to blog link
    const backLink = document.querySelector('.back-to-blog');
    if (backLink) {
        backLink.addEventListener('click', function(e) {
            // Add any custom behavior here if needed
        });
    }
    
    // Handle share button clicks
    const shareLinks = document.querySelectorAll('.share-link');
    shareLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Open in popup window for better UX
            if (this.target === '_blank') {
                e.preventDefault();
                const width = 600;
                const height = 400;
                const left = (screen.width - width) / 2;
                const top = (screen.height - height) / 2;
                
                window.open(
                    this.href,
                    'share',
                    `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
                );
            }
        });
    });
});
</script>
@endpush