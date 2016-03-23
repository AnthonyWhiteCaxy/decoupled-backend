Feature: Index

Scenario: Get a response from index
    When I request "GET /api/index?q=stuff"
    Then I get a "200" response

Scenario: Get a response from index
    When I request "GET /api/index"
    Then I get a "404" response