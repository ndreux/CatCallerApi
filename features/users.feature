Feature: Manage users
  I need to be able to retrieve, create and update them trough the API.

  @createSchema
  @loadFixtures
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

  Scenario: An authentiated user should not be able to retrieve the user list
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/users"
    Then the response status code should be 405
#    And the response should be in JSON

  Scenario: An authenticated user should not be able to create a new user
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/users" with body:
    """
    {
      "email": "newuser@test.com",
      "plainPassword": "toto"
    }
    """
    Then the response status code should be 403
    And the response should be in JSON
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Error",
      "@type": "hydra:Error",
      "hydra:title": "An error occurred",
      "hydra:description": "Access Denied."
    }
    """

  Scenario: An anonymous user should be able to create a new user
    Given I am not authenticated
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/users" with body:
    """
    {
      "email": "newuser@test.com",
      "plainPassword": "toto"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "@context" should be equal to "/contexts/User"
    And the JSON node "@id" should be equal to "/users/6"
    And the JSON node "@type" should be equal to "User"
    And the JSON node "id" should be equal to "6"
    And the JSON node "email" should be equal to "newuser@test.com"
    And the JSON node "status" should be equal to 1
    And the JSON node "createdAt" should exist
    And the JSON node "updatedAt" should exist
    And the JSON node "lastConnectedAt" should be null

  Scenario: An authenticated user should not be able to get the profile of an other user
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/users/2"
    Then the response status code should be 403
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Error",
      "@type": "hydra:Error",
      "hydra:title": "An error occurred",
      "hydra:description": "Access Denied."
    }
    """

  @dropSchema
  Scenario: Au authenticated user should not be able to update the profile of an other user profile
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "PUT" request to "/users/2" with body:
    """
    {
      "plainPassword": "toto"
    }
    """
    Then the response status code should be 403
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
    {
      "@context": "/contexts/Error",
      "@type": "hydra:Error",
      "hydra:title": "An error occurred",
      "hydra:description": "Access Denied."
    }
    """

