<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

// Test Index Method
it('retrieves customer list with search, pagination, and filtering', function () {
    // Seed the database with sample customers
    Customer::factory()->count(5)->create(['firstname' => 'John', 'status' => 'active']);
    Customer::factory()->count(3)->create(['firstname' => 'Jane', 'status' => 'inactive']);

    $response = getJson('/api/customers?search_text=John&page_size=5&page=1');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'data')
        ->assertJsonFragment(['firstname' => 'John']);
});

// Test Store Method
it('creates a new customer successfully', function () {
    $data = [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'telephone' => '1234567890',
        'bvn' => '9876543210',
        'dob' => '1990-05-15',
        'residential_address' => '123 Main Street',
        'state' => 'Lagos',
        'bankcode' => '058',
        'accountnumber' => '1234567890',
        'company_id' => '2',
        'email' => 'john.doe@example.com',
        'city' => 'Ikeja',
        'country' => 'Nigeria',
        'id_card' => '12345',
        'voters_card' => '67890',
        'drivers_licence' => '98765'
    ];

    $response = postJson('/api/customers', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['firstname' => 'John']);

    $this->assertDatabaseHas('customers', ['email' => 'john.doe@example.com']);
});

// Test Store Method Validation Errors
it('fails to create customer with invalid data', function () {
    $data = [
        'firstname' => '', // Required field missing
        'email' => 'invalid-email' // Invalid email format
    ];

    $response = postJson('/api/customers', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['firstname', 'email']);
});

// Test Update Method
it('updates an existing customer successfully', function () {
    $customer = Customer::factory()->create([
        'firstname' => 'John',
        'email' => 'john.doe@example.com'
    ]);

    $data = [
        'firstname' => 'John Updated',
        'email' => 'updated.john@example.com'
    ];

    $response = putJson("/api/customers/{$customer->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment(['firstname' => 'John Updated']);

    $this->assertDatabaseHas('customers', ['email' => 'updated.john@example.com']);
});

// Test Update Method Validation Errors
it('fails to update customer with invalid data', function () {
    $customer = Customer::factory()->create([
        'firstname' => 'John',
        'email' => 'john.doe@example.com'
    ]);

    $data = [
        'email' => 'invalid-email' // Invalid email format
    ];

    $response = putJson("/api/customers/{$customer->id}", $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
