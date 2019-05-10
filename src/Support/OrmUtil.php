<?php
namespace Phooty\Crawler\Support;

use Doctrine\ORM\EntityManagerInterface;

class OrmUtil
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function find(string $model, array $data, callable $no_results)
    {
        $repo = $this->em->getRepository($model);
        $result = $repo->findBy($data);
        if (empty($result)) {
            return call_user_func($no_results, $data);
        }
        return $result[0];
    }
}
