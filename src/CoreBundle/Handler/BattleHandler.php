<?php

namespace CoreBundle\Handler;

use CoreBundle\Entity\Battle;
use CoreBundle\Model\Request\Battle\BattleListRequest;
use CoreBundle\Model\Request\Battle\BattleCreateRequest;
use CoreBundle\Model\Request\Battle\BattleReadRequest;
use CoreBundle\Model\Request\Battle\BattleUpdateRequest;
use CoreBundle\Model\Request\Battle\BattleDeleteRequest;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use CoreBundle\Model\Handler\BattleProcessorInterface;
use CoreBundle\Service\Battle\BattleService;

/**
 * Class BattleHandler
 */
class BattleHandler implements ContainerAwareInterface, BattleProcessorInterface
{
    use ContainerAwareTrait;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var BattleService
     */
    private $battleService;

    /**
     * BattleHandler constructor.
     * @param ContainerInterface $container
     * @param EventDispatcherInterface $eventDispatcher
     * @param BattleService $battleService
     */
    public function __construct(
        ContainerInterface $container,
        EventDispatcherInterface $eventDispatcher,
        BattleService $battleService
    ) {
        $this->setContainer($container);
        $this->eventDispatcher = $eventDispatcher;
        $this->battleService = $battleService;
    }

    /**
     * @inheritdoc
     */
    public function processGetC(BattleListRequest $request): array
    {
        return $this->battleService->getEntitiesByWithListRequestAndTotal(
            [],
            $request
        );
    }

    /**
     * @inheritdoc
     */
    public function processPost(BattleCreateRequest $request): Battle
    {
        return $this->battleService->updatePost($request);
    }

    /**
     * @inheritdoc
     */
    public function processGet(BattleReadRequest $request): Battle
    {
        return $request->getBattle();
    }

    /**
     * @inheritdoc
     */
    public function processPut(BattleUpdateRequest $request): Battle
    {
        return $this->battleService->updatePut($request);
    }

    /**
     * @inheritdoc
     */
    public function processPatch(BattleUpdateRequest $request): Battle
    {
        return $this->battleService->updatePatch($request);
    }

    /**
     * @inheritdoc
     */
    public function processDelete(BattleDeleteRequest $request): Battle
    {
        return $this->battleService->deleteEntity($request->getBattle());
    }
}
