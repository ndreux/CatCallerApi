Feature: Manage reports
  I need to be able to retrieve, create and update them trough the API.

  @createSchema
  @loadFixtures
  Scenario: An anonymous user should not be able to retrieve the reports list
    Given I am not authenticated
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/reports"
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

  Scenario: An anonymous user should not be able to create a new report
    Given I am not authenticated
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/reports"
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

  Scenario: An anonymous user should not be able to update an existing report
    Given I am not authenticated
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "PUT" request to "/reports"
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

  Scenario: An authenticated user should able to retrieve the report list (5 results)
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/reports"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "@context" should be equal to "/contexts/Report"
    And the JSON node "@id" should be equal to "/reports"
    And the JSON node "@type" should be equal to "hydra:Collection"
    And the JSON node "hydra:member" should have "5" element
    And the JSON node "hydra:totalItems" should be equal to "5"

  Scenario: An authenticated user should able to retrieve the report of a specific report
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/reports/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "@context" should be equal to "/contexts/Report"
    And the JSON node "@id" should be equal to "/reports/1"
    And the JSON node "@type" should be equal to "Report"
    And the JSON node "reporter" should not be null
    And the JSON node "type" should not be null
    And the JSON node "createdAt" should not be null
    And the JSON node "updatedAt" should not be null
    And the JSON node "harassment" should not be null
    And the JSON node "harassment.@id" should not be null
    And the JSON node "harassment.@type" should be equal to "Harassment"
    And the JSON node "harassment.id" should not be null
    And the JSON node "harassment.datetime" should not be null
    And the JSON node "harassment.location" should not be null
    And the JSON node "harassment.location.@type" should be equal to "Location"
    And the JSON node "harassment.location.latitude" should not be null
    And the JSON node "harassment.location.longitude" should not be null
    And the JSON node "harassment.types" should not be null
    And the JSON node "harassment.types[0].@type" should be equal to "HarassmentType"
    And the JSON node "harassment.types[0].label" should not be null
    And the JSON node "harassment.note" should exist
    And the JSON node "harassment.createdAt" should not be null
    And the JSON node "harassment.updatedAt" should not be null

  @dropSchema
  Scenario: An authenticated user should be able to create a new report
    Given I am authenticated as "user@test.com"
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/reports" with body:
    """
    {
      "reporter": "/users/1",
      "harassment": {
        "datetime": "2001-09-24T09:27:44+00:00",
        "location": {
          "longitude": "-148.983581",
          "latitude": "4.723938"
        },
        "types": [
          "/harassment_types/4",
          "/harassment_types/5"
        ],
        "note": "aut officia aut aut blanditiis et ducimus eos odit amet et est ut eum nisi"
      },
      "type": 2
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "@context" should be equal to "/contexts/Report"
    And the JSON node "@id" should be equal to "/reports/6"
    And the JSON node "@type" should be equal to "Report"
    And the JSON node "id" should be equal to "6"
    And the JSON node "reporter" should be equal to "/users/1"
    And the JSON node "type" should be equal to 2
    And the JSON node "createdAt" should not be null
    And the JSON node "updatedAt" should not be null
    And the JSON node "harassment" should not be null
    And the JSON node "harassment.@id" should be equal to "/harassments/6"
    And the JSON node "harassment.@type" should be equal to "Harassment"
    And the JSON node "harassment.id" should be equal to 6
    And the JSON node "harassment.datetime" should be equal to "2001-09-24T09:27:44+00:00"
    And the JSON node "harassment.location" should not be null
    And the JSON node "harassment.location.@id" should be equal to "/locations/51"
    And the JSON node "harassment.location.@type" should be equal to "Location"
    And the JSON node "harassment.location.longitude" should be equal to "-148.983581"
    And the JSON node "harassment.location.latitude" should be equal to "4.723938"
    And the JSON node "harassment.types" should have "2" element
    And the JSON node "harassment.types[0].@type" should be equal to "HarassmentType"
    And the JSON node "harassment.types[0].@id" should be equal to "/harassment_types/4"
    And the JSON node "harassment.types[0].label" should be equal to "Race"
    And the JSON node "harassment.types[1].@type" should be equal to "HarassmentType"
    And the JSON node "harassment.types[1].@id" should be equal to "/harassment_types/5"
    And the JSON node "harassment.types[1].label" should be equal to "Religious Beliefs"
    And the JSON node "harassment.note" should be equal to "aut officia aut aut blanditiis et ducimus eos odit amet et est ut eum nisi"
    And the JSON node "harassment.createdAt" should not be null
    And the JSON node "harassment.updatedAt" should not be null

