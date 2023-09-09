<?php

it("avoid the use of debug methods")
    ->expect(['ds', 'dd', 'dump', 'ray'])
    ->not->toBeUsed();