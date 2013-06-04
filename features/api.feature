@api @crud
Feature: Testing initial Api

    Scenario: Get access all user
        When I request "/access/all"
        Then the response status code should be 200
        And the response should be JSON

    Scenario: Get access user
        When I request "/access/user"
        Then the response status code should be 401
        And the response should be JSON
        And the response has a "error" property

    Scenario: Get access admin
        When I request "/access/admin"
        Then the response status code should be 401
        And the response should be JSON
        And the response has a "error" property

    Scenario: Get access admin auth basic
        Given that I log in with "67890" and "x"
        When I request "/access/admin"
        Then the response status code should be 200
        And the response should be JSON
        And the response has a "error" property
