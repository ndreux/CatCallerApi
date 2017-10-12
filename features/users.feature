Feature: Manage users
  I need to be able to retrieve, create and update them trough the API.

  Scenario: I want to authenticate an active user with valid login/password
    When I add "Content-type" header equal to "application/x-www-form-urlencoded; charset=utf-8"
    And I send a "POST" request to "/login_check" with parameters:
      | key       | value         |
      | _username | user@test.com |
      | _password | test          |
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "token" should exist


  Scenario: Retrieve the user list
    Given I am authenticated as "user@test.com"
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/users"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "@context" should be equal to "/contexts/User"
    And the JSON node "@id" should be equal to "/users"
    And the JSON node "@type" should be equal to "hydra:Collection"
    And the JSON node "hydra:member" should have "5" element
    And the JSON node "hydra:totalItems" should be equal to "5"
