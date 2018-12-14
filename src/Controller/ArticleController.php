<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route(
     *     name="validate_article",
     *     path="/api/articles/{id}/validate",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=Article::class,
     *         "_api_item_operation_name"="validate_article"
     *     }
     * )
     *
     * @IsGranted("ROLE_VOTER", subject="article", message="Access Denied")
     */
    public function validateArticle(Article $article)
    {
        $article->setIsValid(true);

        return $article;
    }

}