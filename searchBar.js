document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var input = document.getElementById('searchInput').value;
  
    if(input.trim() !== '') {
      // Save the user input search into search history bar
      let history = localStorage.getItem('searchHistory');
      history = history ? JSON.parse(history) : [];
      history.push(input);
      localStorage.setItem('searchHistory', JSON.stringify(history));
      
      // Adjust here in the future
      document.getElementById('searchResults').classList.remove('hidden');
    } else {
      document.getElementById('searchResults').classList.add('hidden');
    }
  });
s  