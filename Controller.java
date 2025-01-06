package com.example.sortserver.controller;

import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.stream.Collectors;

@RestController
@RequestMapping("/api/sort")
public class SortController {

    @PostMapping("/ascending")
    public List<Integer> sortAscending(@RequestBody List<Integer> numbers) {
        List<Integer> sortedNumbers = numbers.stream()
                .sorted()
                .collect(Collectors.toList());
        System.out.println("Received numbers: " + numbers);
        System.out.println("Sorted numbers: " + sortedNumbers);
        return sortedNumbers;
    }
}
