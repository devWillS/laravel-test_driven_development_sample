<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use phpDocumentor\Reflection\Types\This;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataSeeder']);
    }

    /**
     * @test
     */
    public function api_customersにGETメソッドアクセスできる()
    {
        $response = $this->get('api/customers');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customersにPOSTメソッドアクセスできる()
    {
        $customer = [
            'name' => 'customer_name',
        ];
        $response = $this->postJson('api/customers', $customer);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_customer_idにGETメソッドアクセスできる()
    {
        $response = $this->get('api/customers/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_customer_idにPUTメソッドアクセスできる()
    {
        $response = $this->put('api/customers/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_customer_idにDELETEメソッドアクセスできる()
    {
        $response = $this->delete('api/customers/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reportsにGETメソッドアクセスできる()
    {
        $response = $this->get('api/reports');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reportsにPOSTメソッドアクセスできる()
    {
        $response = $this->post('api/reports');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_report_idにGETメソッドアクセスできる()
    {
        $response = $this->get('api/reports/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_report_idにPUTメソッドアクセスできる()
    {
        $response = $this->put('api/reports/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_reports_report_idにDELETEメソッドアクセスできる()
    {
        $response = $this->delete('api/reports/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get('api/customers');
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_customersにGETメソッドで取得できる顧客情報のJSON形式は要件通りである()
    {
        $response = $this->get('api/customers');
        $customers = $response->json();
        $customer = $customers[0];
        $this->assertSame(['id', 'name'], array_keys($customer));
    }

    /**
     * @test
     */
    public function api_customersに顧客名をPOSTするとcustomersテーブルにそのデータが追加される()
    {
        $params = [
            'name' => '顧客名',
        ];
        $this->postJson('api/customers', $params);
        $this->assertDatabaseHas('customers', $params);
    }

    /**
     * @test
     */
    public function api_customersにnameが含まれない場合422UnprocessableEntityが返却される()
    {
        $params = [];
        $response = $this->postJson('api/customers', $params);
        $response->assertStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function api_customersにnameが空の場合422UnprocessableEntityが返却される()
    {
        $params = ['name' => ''];
        $response = $this->postJson('api/customers', $params);
        $response->assertStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function POST_api_customersのエラーレスポンスの確認()
    {
        $params = ['name' => ''];
        $response = $this->postJson('api/customers', $params);
        $error_response = [
            'message' => 'name は必須項目です',
            'errors' => [
                'name' => [
                    'name は必須項目です'
                ],
            ]
        ];
        $response->assertExactJson($error_response);
    }
}
