<?php

namespace App\EventListener;

use App\Repository\Blog\ArticleRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ArticleRepository    $articleRepository
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, ArticleRepository $articleRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerBlogPostsUrls($event->getUrlContainer());
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerBlogPostsUrls(UrlContainerInterface $urls): void
    {
        $posts = $this->articleRepository->findAll();

        foreach ($posts as $post) {
            $url = $this->urlGenerator->generate('blog_show', ['slug' => $post->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);
            $urls->addUrl(
                new UrlConcrete(
                    $url,
                    new \Datetime(),
                    UrlConcrete::CHANGEFREQ_WEEKLY,
                    0.7
                ),
                'blog'
            );
        }
    }
}