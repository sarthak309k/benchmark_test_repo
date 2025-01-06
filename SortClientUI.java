import javafx.application.Application;
import javafx.geometry.Insets;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.*;
import javafx.stage.Stage;
import org.springframework.http.*;
import org.springframework.web.client.RestTemplate;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class SortClientUI extends Application {

    private final RestTemplate restTemplate = new RestTemplate();
    private final String serverUrl = "http://localhost:8080/api/sort/ascending";

    @Override
    public void start(Stage primaryStage) {
        // UI Components
        Label inputLabel = new Label("Enter numbers (comma-separated):");
        TextField inputField = new TextField();
        Button sortButton = new Button("Sort");
        TextArea outputArea = new TextArea();

        outputArea.setEditable(false);
        outputArea.setPromptText("Sorted numbers will appear here...");

        // Layout
        VBox layout = new VBox(10);
        layout.setPadding(new Insets(15));
        layout.getChildren().addAll(inputLabel, inputField, sortButton, outputArea);

        // Button Action
        sortButton.setOnAction(event -> {
            String input = inputField.getText();
            if (input.isEmpty()) {
                outputArea.setText("Please enter some numbers.");
                return;
            }

            // Convert input to a list of integers
            try {
                List<Integer> numbers = new ArrayList<>();
                for (String num : input.split(",")) {
                    numbers.add(Integer.parseInt(num.trim()));
                }

                // Send request to server
                HttpHeaders headers = new HttpHeaders();
                headers.setContentType(MediaType.APPLICATION_JSON);
                HttpEntity<List<Integer>> request = new HttpEntity<>(numbers, headers);

                ResponseEntity<Integer[]> response = restTemplate.exchange(
                        serverUrl,
                        HttpMethod.POST,
                        request,
                        Integer[].class
                );

                // Display sorted numbers
                List<Integer> sortedNumbers = Arrays.asList(response.getBody());
                outputArea.setText("Sorted Numbers: " + sortedNumbers);

            } catch (NumberFormatException e) {
                outputArea.setText("Invalid input. Please enter only numbers separated by commas.");
            } catch (Exception e) {
                outputArea.setText("Error connecting to server. Please ensure the server is running.");
                e.printStackTrace();
            }
        });

        // Scene and Stage
        Scene scene = new Scene(layout, 400, 300);
        primaryStage.setTitle("Sort Client");
        primaryStage.setScene(scene);
        primaryStage.show();
    }

    public static void main(String[] args) {
        launch(args);
    }
}
