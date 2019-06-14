<?php
namespace Phooty\Crawler\Crawler;

use Phooty\Crawler\Mappings\Mapping;
use Illuminate\Contracts\Container\Container;
use Phooty\Crawler\Results;

abstract class BaseCrawler implements Crawler
{
    /**
     * The result data
     *
     * @var Results
     */
    protected $results;

    /**
     * The Column Mappings
     *
     * @var Mapping
     */
    protected $mappings;

    /**
     * The Container instance
     *
     * @var Container
     */
    protected $container;

    protected $processors = [];
    
    /**
     * Crawls through the response html and returns an array of results.
     *
     * @param string $html
     * @return Results
     */
    abstract public function crawl(string $html): Results;

    public function __construct(Container $container, Mapping $mappings)
    {
        $this->container = $container;
        $this->mappings = $mappings;
    }

    /**
     * Returns a factory instance by alias
     *
     * @param string $factory
     * @return \Phooty\Crawler\Factory\DataFactory
     */
    public function factory(string $factory = null)
    {
        /* if ($this->container->has("factory.{$factory}")) {
            dd($factory);
        } */
        return $this->container->make("factory.{$factory}");
    }

    /**
     * Return the Results object
     *
     * @return Results
     */
    public function result(): Results
    {
        isset($this->results) ?: $this->results = $this->container->make(Results::class);
        return $this->results;
    }

    /**
     * Return a processor instance by classname.
     * 
     * Allows sharing processors within a Crawler without registering shared
     * instances with the Container.
     *
     * @param string $className
     * @return \Phooty\Crawler\Processor\Node\NodeProcessor
     * 
     * @throws \InvalidArgumentException Thrown if class is not found
     */
    public function processor(string $className)
    {
        if (!isset($this->processors[$className])) {
            if (!class_exists($className)) {
                throw new \InvalidArgumentException(
                    "Could not locate {$className}"
                );
            }
            $this->processors[$className] = $this->container->make($className);
        }
        return $this->processors[$className];
    }
}
