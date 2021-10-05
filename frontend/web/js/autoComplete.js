if(document.querySelector('#autoComplete')) {
  new autoComplete({
    data: {                              // Data src [Array, Function, Async] | (REQUIRED)
      src: async () => {
        // User search query
        const query = document.querySelector("#autoComplete").value;
        // Fetch External Data Source
        const source = await fetch(`http://task-force.academy/location/?address=${query}`);
        // Format data into JSON
        const data = await source.json();
        // Return Fetched data
        console.log(data);
        return data;
      },
      key: ["formatted"],
      cache: false
    },
    placeHolder: "Санкт-Петербург, Калининский район",     // Place Holder text                 | (Optional)
    selector: "#autoComplete",           // Input field selector              | (Optional)
    threshold: 3,                        // Min. Chars length to start Engine | (Optional)
    debounce: 600,                       // Post duration for engine to start | (Optional)
    searchEngine: "strict",              // Search Engine type/mode           | (Optional)
    resultsList: {                       // Rendered results list object      | (Optional)
      render: true,
      container: source => {
        source.setAttribute("id", "autoComplete_list");
      },
      destination: document.querySelector("#autoComplete"),
      position: "afterend",
      addClass: 'class',
      element: "ul"
    },
    maxResults: 5,                         // Max. number of rendered results | (Optional)
    highlight: true,                       // Highlight matching results      | (Optional)
    resultItem: {                          // Rendered result item            | (Optional)
      content: (data, source) => {
        source.innerHTML = data.match;
      },
      element: "li"
    },
    noResults: () => {                     // Action script on noResults      | (Optional)
      const result = document.createElement("li");
      result.setAttribute("class", "no_result");
      result.setAttribute("tabindex", "1");
      result.innerHTML = "No Results";
      document.querySelector("#autoComplete_list").appendChild(result);
    },
    onSelection: feedback => {             // Action script onSelection event | (Optional)
      const query = document.querySelector("#autoComplete").value = feedback.selection.value.formatted;
    }
  });
}
