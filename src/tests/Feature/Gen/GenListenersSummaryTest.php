<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class GenListenersSummaryTest extends TestCase
{
    public function testNoParam()
    {
        $response = $this->get('/api/listeners');
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Record not found']);
    }

    public function testRecentHourly()
    {
        $response = $this->get('/api/listeners?ymd=20240409');
        $response->assertStatus(200);
        $response->assertJson(['53', '44', '44', '42', '41', '43', '44', '44', '43', '37', '39', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']);

        $response = $this->get('/api/listeners?mode=recentHourly&ymd=20240409');
        $response->assertStatus(200);
        $response->assertJson(['53', '44', '44', '42', '41', '43', '44', '44', '43', '37', '39', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']);

        $response = $this->get('/api/listeners?mode=recentHourly&ymd=202404');
        $response->assertStatus(500);
        $response->assertJsonFragment(['message' => 'Invalid ymd format.']);
    }

    public function testRecentDaily()
    {
        $response = $this->get('/api/listeners?mode=recentDaily&ymd=202404');
        $response->assertStatus(200);
        $response->assertJson(['0', '42', '43', '48', '45', '45', '47', '42', '43', '43', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']);

        $response = $this->get('/api/listeners?mode=recentDaily&ymd=2024');
        $response->assertStatus(500);
        $response->assertJsonFragment(['message' => 'Invalid ymd format.']);
    }

    public function testOverallHourly()
    {
        $response = $this->get('/api/listeners?mode=overallHourly');
        $response->assertStatus(200);
        $response->assertJson(['48', '49', '48', '47', '47', '47', '45', '44', '43', '39', '38', '37', '36', '37', '38', '41', '42', '41', '42', '42', '42', '44', '46', '48']);
    }

    public function testOverallWeekly()
    {
        $response = $this->get('/api/listeners?mode=overallWeekly');
        $response->assertStatus(200);
        $response->assertJson(['43', '41', '44', '45', '40', '42', '45']);
    }
}
