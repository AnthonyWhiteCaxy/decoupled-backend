<?php

namespace Caxy\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Nelmio\ApiDoc(
     *  section="Index",
     *  description="Sample Endpoint",
     * )
     * @FOSRest\QueryParam(name="q", nullable=true, description="Search Term for Everything")
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return array
     *
     * @FOSRest\View()
     * @FOSRest\Get("/api/index")
     */
    public function indexAction(ParamFetcher $paramFetcher)
    {
        $parameters = array_filter($paramFetcher->all());

        if (!$parameters) {
            throw new NotFoundHttpException("No Parameters");
        }

        return $parameters;
    }
}
