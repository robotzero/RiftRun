Feature: Create new Posts

Scenario: I can create new post
    # When I request "POST /v1/posts" with the payload:
    When I send a POST request to "/v1/posts" with values:
        | player | type:dh,paragonPonts:40,battleTag: 01, region: eu |
        | query  | minParagon: 30 |
    Then The response code should be 201

