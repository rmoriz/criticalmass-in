<?php declare(strict_types=1);

namespace App\Controller;

use App\Traits\RepositoryTrait;
use App\Traits\UtilTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    use RepositoryTrait;
    use UtilTrait;

    protected function isLoggedIn(): bool
    {
        return $this
            ->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
    }

    protected function isFeatureEnabled(string $featureName): bool
    {
        $parameterName = sprintf('feature.%s', $featureName);

        return $this->getParameter($parameterName) === true;
    }

    protected function errorIfFeatureDisabled(string $featureName): void
    {
        if (!$this->isFeatureEnabled($featureName)) {
            throw $this->createNotFoundException();
        }
    }
}
