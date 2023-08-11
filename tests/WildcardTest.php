<?php

it('can route blade', function () {
    $response = $this->get('/view/blade/test/blade');
    $response->assertStatus(200);
    $response->assertSee('test');
})->skip('wildcards are a wip');
