<?php

it('can route to index', function () {
    $response = $this->get('/view');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');
});

it('can route blade', function () {
    $response = $this->get('/view/blade/blade');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');
});

it('can route to index with a trailing slash', function () {
    $response = $this->get('/view/');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');

    $response = $this->get('/view/blade/');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');
});
