<?php

namespace OneHRMS\interface;

interface CrudInterface
{
    public function add();
    public function listAll();
    public function findOne($id);
    public function update($id);
    public function delete($id);
    public function validate($data);
}
