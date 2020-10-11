## Notes:

For **Task 1**, to check	 the entire json data, you can simply access it at: http://127.0.0.1:8000/api/data. If you want to access all information about a specific person, you can access that at: http://127.0.0.1:8000/api/data/(Id), e.g., http://127.0.0.1:8000/api/data/1.

To access each subtask of **Task 2**, use the following links:

a. http://127.0.0.1:8000/api/car/(Number_Plate), e.g :http://127.0.0.1:8000/api/car/BAT6754

b. http://127.0.0.1:8000/api/person/(Id)/car, e.g.http://127.0.0.1:8000/api/person/1/car

c. http://127.0.0.1:8000/api/getPersonsByCar?color="Some_Color" e.g., http://127.0.0.1:8000/api/getPersonsByCar?color="Green"
Here the color can be written with both Uppercase letters or lowercase letters.

d. http://127.0.0.1:8000/api/getPersonsOlderThan?age=(Some_Integer), e.g., http://127.0.0.1:8000/api/getPersonsOlderThan?age=50
Here the age should be an integer, without quotation marks (" ")

e. http://127.0.0.1:8000/api/getPersonsWithInsurance

This app was tested using postman. 
