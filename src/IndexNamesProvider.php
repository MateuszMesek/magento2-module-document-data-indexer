<?php declare(strict_types=1);

namespace MateuszMesek\DocumentDataIndex;

use MateuszMesek\DocumentDataIndex\Action\DimensionProviderFactory;
use MateuszMesek\DocumentDataIndexApi\IndexNameResolverInterface;
use MateuszMesek\DocumentDataIndexApi\IndexNamesProviderInterface;
use Traversable;

class IndexNamesProvider implements IndexNamesProviderInterface
{
    private DimensionProviderFactory $dimensionProviderFactory;
    private IndexNameResolverInterface $indexNameResolver;
    private string $documentName;

    public function __construct(
        DimensionProviderFactory $dimensionProviderFactory,
        IndexNameResolverInterface $indexNameResolver,
        string $documentName
    )
    {
        $this->dimensionProviderFactory = $dimensionProviderFactory;
        $this->indexNameResolver = $indexNameResolver;
        $this->documentName = $documentName;
    }

    public function getIndexNames(): Traversable
    {
        $dimensionProvider = $this->dimensionProviderFactory->create($this->documentName);

        foreach ($dimensionProvider->getIterator() as $dimensions) {
            yield $this->indexNameResolver->resolve($dimensions);
        }
    }
}
