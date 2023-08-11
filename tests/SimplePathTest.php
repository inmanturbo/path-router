<?php

it('can route to index', function () {
    $response = $this->get('/path');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');
});

it('can route blade', function () {
    $response = $this->get('/path/blade/blade');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');
});

it('can route to index with a trailing slash', function () {
    $response = $this->get('/path/');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');

    $response = $this->get('/path/blade/');
    $response->assertStatus(200);
    $response->assertSee('Hello World!');
});
