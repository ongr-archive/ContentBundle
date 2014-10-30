<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for content pages.
 *
 * @SuppressWarnings(UnusedFormalParameter)
 */
class ContentController extends Controller
{
    /**
     * Returns template data for snippetAction.
     *
     * @param string $slug
     *
     * @return array
     */
    protected function snippetActionData($slug)
    {
        return $this->get('ongr_content.content_service')->getDataForSnippet($slug);
    }

    /**
     * Render cms body in template.
     *
     * @param string $slug
     * @param string $template
     *
     * @return Response
     */
    public function snippetAction(
        $slug,
        $template = 'ONGRContentBundle:Content:plain_cms_snippet.html.twig'
    ) {
        return $this->render(
            $template,
            $this->snippetActionData($slug)
        );
    }
}
