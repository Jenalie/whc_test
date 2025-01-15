# Command Web App

## Technologies Used

- Web server: Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12
- Back-end: PHP
- Front-end: HTML + CSS + JavaScript + AJAX
- Repository: Github

## Implemented Commands:

1. **add:** adds numeric arguments
2. **sort-asc:** sort arguments in ascending order.
3. **repo-desc:** perform a GitHub API call using owner and repo arguments to return adescription of the repository.

## Example Usage:

**Command: add 3 12 20 5**
- Result: 40
  
**Command: sort-asc 50 10 30 5**
- Result: 5 10 30 50
  
**Command: repo-desc Jenalie whc_test**
- Result: Description of the linux repository from GitHub.

## Added command handlers (optional):

**Command: subtract 100 20 50**
- Result: 30

**Command: divide 80 2 4**
- Result: 10

**Command: multiply 5 1 12**
- Result: 60

**Command: sort-desc 50 10 30 5**
- Result: 50 30 10 5
