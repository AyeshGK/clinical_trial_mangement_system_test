<?php

namespace app\core;

abstract class Migration
{
    public abstract function up();

    public abstract function down();

}