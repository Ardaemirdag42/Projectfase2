<?php

<<<<<<< HEAD
it('returns a successful response', function () {
=======
test('the application returns a successful response', function () {
>>>>>>> origin/Deniz
    $response = $this->get('/');

    $response->assertStatus(200);
});
