<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behatch\Context\RestContext;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\Process\Process;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    const DEFAULT_TIMEOUT = 3600;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $manager;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @var array
     */
    private $classes;

    /**
     * @var JWTManager
     */
    private $jwtManager;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(ManagerRegistry $doctrine, JWTManager $jwtManager)
    {
        $this->doctrine   = $doctrine;
        $this->jwtManager = $jwtManager;
        $this->manager    = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes    = $this->manager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * @param BeforeScenarioScope $scope
     *
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        /** @var \Behat\Behat\Context\Environment\InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();

        /** @var RestContext restContext */
        $this->restContext = $environment->getContext(RestContext::class);
    }

    /**
     * @BeforeScenario @createSchema
     */
    public function createDatabase()
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @BeforeScenario @loadFixtures
     */
    public function loadFixtures()
    {
        $process = new Process('php bin/console hautelook:fixture:load --no-interaction --env=test');
        $process->setTimeout(self::DEFAULT_TIMEOUT);
        $process->run();
    }

    /**
     * @AfterScenario @dropSchema
     */
    public function dropDatabase()
    {
        $this->schemaTool->dropSchema($this->classes);
    }

    /**
     * @param string $email
     *
     * @throws Exception
     *
     * @Given /^I am authenticated as "([^"]*)"$/
     */
    public function iAmAuthenticatedAs($email)
    {
        $user  = $this->manager->getRepository('AppBundle:User')->findOneByEmail($email);
        $token = $this->jwtManager->create($user);

        $this->restContext->iAddHeaderEqualTo('Authorization', 'Bearer '.$token);
    }

    /**
     * @Given /^I am not authenticated$/
     */
    public function iAmNotAuthenticated()
    {
        $this->restContext->iAddHeaderEqualTo('Authorization', null);
    }
}
