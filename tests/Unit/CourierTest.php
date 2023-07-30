<?php

// ~\courier-backend\tests\Unit\CourierTest.php

use App\Models\Courier;
use Database\Factories\CourierTestFactory;

class CourierTest extends \Tests\TestCase
{
    // function index for get all courier data
    public function test_expected_to_find_all_couriers_list(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers");
        $response->assertStatus(200);
    }

    // pagination response
    public function test_expected_to_show_all_couriers_list_with_pagination(): void
    {
        $this->withoutExceptionHandling();
        $randPageSize = rand(1,10);
        $response = $this->get("api/couriers?pageSize=" . $randPageSize);
        $response->assertStatus(200);
    }

    // pagination response error because of non digits input
    public function test_expected_to_get_error_by_preg_match_from_couriers_list_with_pagination(): void
    {
        $this->withoutExceptionHandling();
        $nonDigitData = "A";
        $response = $this->get("api/couriers?pageSize=" . $nonDigitData);
        $response->assertStatus(422);
    }

    // pagination response error because of null input
    public function test_expected_to_get_error_by_null_from_couriers_list_with_pagination(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?pageSize=" . null);
        $response->assertStatus(400);
    }

    // sort by DOJ Descending
    public function test_expected_to_get_the_courier_list_data_in_descending_order_by_using_DOJ(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=-DOJ");
        $response->assertStatus(200);
    }

    // sort by dateofjoined Descending
    public function test_expected_to_get_the_courier_list_data_in_descending_order_by_using_dateofjoined(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=-dateofjoined");
        $response->assertStatus(200);
    }

    // sort by DOJ Ascending
    public function test_expected_to_get_the_courier_list_data_in_ascending_order_by_using_DOJ(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=DOJ");
        $response->assertStatus(200);
    }

    // sort by dateofjoined Ascending
    public function test_expected_to_get_the_courier_list_data_in_ascending_order_by_using_dateofjoined(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=dateofjoined");
        $response->assertStatus(200);
    }

    // sort by DOJ Ascending
    public function test_expected_also_to_get_the_courier_list_data_in_ascending_order_by_using_DOJ(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=+DOJ");
        $response->assertStatus(200);
    }

    // sort by dateofjoined Ascending
    public function test_expected_also_to_get_the_courier_list_data_in_ascending_order_by_using_dateofjoined(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=+dateofjoined");
        $response->assertStatus(200);
    }

    // sort by DOJ error because of the incorrect value
    public function test_expected_to_get_error_rather_than_show_the_sorted_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=@DOJ");
        $response->assertStatus(422);
    }

    // sort by DOJ error because of the null value
    public function test_expected_to_get_error_by_null_rather_than_show_the_sorted_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?sort=" . null);
        $response->assertStatus(400);
    }

    // search by Name value
    public function test_expected_to_search_for_courier_names_to_produce_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?search=a");
        $response->assertStatus(200);
    }

    // search by name that doesn't exist
    public function test_expected_to_get_error_by_non_existent_name_in_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?search=Faiq");
        $response->assertStatus(404);
    }

    // search by incorrect name value
    public function test_expected_to_get_error_by_incorrect_name_value_in_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?search=Faiq97");
        $response->assertStatus(422);
    }

    // search by null value
    public function test_expected_to_get_error_by_null_value_in_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?search=" . null);
        $response->assertStatus(400);
    }

    // search by level value
    public function test_expected_to_search_for_courier_level_to_produce_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?level=1,2");
        $response->assertStatus(200);
    }

    // search by incorrect level value
    public function test_expected_to_get_error_by_non_existent_courier_level_in_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?level=10,20");
        $response->assertStatus(404);
    }

    // search by incorrect level value
    public function test_expected_to_get_error_by_non_digits_courier_level_in_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?level=aku,faiq");
        $response->assertStatus(400);
    }

    // search by null value
    public function test_expected_to_get_error_by_null_level_value_in_courier_list_data(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get("api/couriers?level=" . null);
        $response->assertStatus(422);
    }

    // find courier data by the courier id
    public function test_expected_to_find_courier_data(): void
    {
        $this->withoutExceptionHandling();
        $courierId = Courier::inRandomOrder()->first()->id;
        $response = $this->get("api/couriers/" . $courierId);
        $response->assertStatus(200);
    }

    // find courier data by the incorrect courier id value
    public function test_expected_to_get_error_when_finding_courier_data(): void
    {
        $this->withoutExceptionHandling();;
        $response = $this->get("api/couriers/AA");
        $response->assertStatus(404);
    }

    // create a courier data
    public function test_expected_to_create_a_new_courier(): void
    {
        $this->withoutExceptionHandling();
        $courierTest = new CourierTestFactory();
        $courierData = $courierTest->raw();
        $response = $this->postJson("api/couriers", $courierData);
        $response->assertStatus(201);
    }

    // update a courier data
    public function test_expected_to_update_a_courier_data(): void
    {
        $this->withoutExceptionHandling();
        $courierTest = new CourierTestFactory();
        $courierId = Courier::inRandomOrder()->first()->id;
        $courierData = $courierTest->raw();
        $response = $this->putJson("api/couriers/{$courierId}", $courierData);
        $response->assertStatus(200);
    }

    // update a courier data by incorrect courier id value
    public function test_expected_to_get_error_by_incorrect_ID_in_updating_a_courier_data(): void
    {
        $this->withoutExceptionHandling();
        $courierTest = new CourierTestFactory();
        $courierId = "faiq";
        $courierData = $courierTest->raw();
        $response = $this->putJson("api/couriers/{$courierId}", $courierData);
        $response->assertStatus(404);
    }

    // delete a courier data
    public function test_expected_to_delete_a_courier_data(): void
    {
        $this->withoutExceptionHandling();
        $courierTest = new CourierTestFactory();
        $courierId = Courier::inRandomOrder()->first()->id;
        $response = $this->deleteJson("api/couriers/{$courierId}");
        $response->assertStatus(200);
    }

    // delete a courier data by incorrect courier id value
    public function test_expected_to_get_error_by_incorrect_ID_in_deleting_a_courier_data(): void
    {
        $this->withoutExceptionHandling();
        $courierTest = new CourierTestFactory();
        $courierId = "faiq";
        $response = $this->deleteJson("api/couriers/{$courierId}");
        $response->assertStatus(404);
    }
}
