<?php

namespace App\Model;

interface FetchClass
{
    /**
     * Returns true if the exists, false if not
     *
     * @return bool
     */
    public function exists();
}