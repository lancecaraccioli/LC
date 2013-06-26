<?php
interface LC_Persistence_Gateway
{
    public function setCriteria(LC_Persistence_Criteria);

    public function persist($entity);

    public function find();
}
