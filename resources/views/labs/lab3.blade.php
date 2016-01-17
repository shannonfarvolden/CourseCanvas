@extends('app')

@section('content')
    <div class="jumbotron">
        <h2>Lab 3 [22 pts]</h2>

        <p>Practicing Conditionals</p>
        The purpose of this lab is to give you hands on practice with boolean
        expressions and conditional statements.
        If you need clarification with any of the steps below, ask your TA and/or
        your neighbour.
        <p></p>
        <b>What to Submit:</b>
        <ul>
            <li>Typed answers for the boolean expressions exercise
            <li><tt>FindNumDays.java</tt>
            <li>Typed answers for the guessing game
        </ul>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">1. Boolean expressions [9 pts]</h3>
        </div>
        <div class="panel-body">
            <p>
                This exercise helps you get comfortable with evaluating boolean
                expressions. For each of the following questions, indicate if the final
                result is true or false. You should ideally do this by hand (with pen
                and paper) because these types of questions will be similar to those
                that appear on handwritten exams. However, for this lab, you can also
                type the expression into Eclipse to help you verify your own answers.
                Make sure you understand why the expressions evaluate to that particular
                outcome.

            <p>
                <b>[1 pt each]</b>
                Indicate the resulting value of each of the following:

            <ol>
                <li><tt>!!false</tt>
                <li><tt>true && true || false</tt>
                <li><tt>2 * 2 - 3 > 2 && 4 - 2 < 5</tt>
                <li><tt>2 * 2 - 3 > 2 || 4 - 2 < 5</tt>
                <li><tt>(x > 0 || (x < 10 && y < 0 ))</tt>, assume x = 5 and y = 2
                <li><tt>!( x > 0 ) ^ ( y == 2 )</tt>, assume x = 5 and y = 2
                <li><tt>(x + y > 10) && y < 5</tt>, assume x = 5 and y = 2
                <li><tt>!y < 5</tt>, assume y = 2
                <li><tt>(x + y > 10) || !(y < 5)</tt>, assume x = 5 and y = 2
            </ol>

            Note: one of the expressions above generates a syntax error and cannot
            be evaluated. You must identify that expression and explain why an error
            occurred to get full marks.


        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">2. Find Number of Days [9 pts]</h3>
        </div>
        <div class="panel-body">
            <p>
                <b>[1 pt]</b>
                This exercise gives you practice using comparison operators and nested
                if-statements.
                First, create a program called <tt>FindNumDays</tt>.

            <p>
                <b>[1 pt]</b>
                Prompt the user to enter the month (as an integer from 1 to 12) and year
                (as an integer with 4 digits).

            <p>
                <b>[1 pt]</b>
                Be sure to check that the month and year entered are within the valid ranges.

            <p>
                <b>[1 pt]</b>
                If the entered month and year are valid, the program may continue.
                Otherwise, print out an error message to the user and the program will
                end.

            <p>
                <b>[1 pt]</b>
                Check if the year entered by the user is a leap year. Keep track of this
                result in a boolean variable. (Recall the definition of a leap year
                reviewed in the slides and also in the textbook.)

            <p>
                <b>[1 pt]</b>
                A month has 30 days in April, June, September, and November, and 31 days
                in all the other months aside from February. In February, a month has 29
                days in a leap year, and only 28 days otherwise. Write the neceesary
                if-statements to determine the number of days there are in the month
                entered by the user.

            <p>
                <b>[1 pt]</b>
                Display the number of days back to the user.

            <p>
                <b>[1 pt]</b>
                Note that when you display the information, the n'th month will need to
                be printed based on month, so that you use "1st" for January, "2nd" for
                February, "3rd" for March, and "nth" for the other months. See sample
                output below for clarification.

            <p>
                Sample output:
      <pre>
Enter a month (e.g., 1 for January):
0
Enter a year (e.g., 2012):
1234
Invalid input - please restart the program
      </pre>
            <p>
                Sample output:
      <pre>
Enter a month (e.g., 1 for January):
3
Enter a year (e.g., 2012):
123
Invalid input - please restart the program
      </pre>
            <p>
                Sample output:
      <pre>
Enter a month (e.g., 1 for January):
6
Enter a year (e.g., 2012):
2014
There are 30 for the 6th month of year 2014
      </pre>
            <p>
                Sample output:
      <pre>
Enter a month (e.g., 1 for January):
2
Enter a year (e.g., 2012):
2012
There are 29 for the 2nd month of year 2012
      </pre>
            <p>
                Sample output:
      <pre>
Enter a month (e.g., 1 for January):
2
Enter a year (e.g., 2012):
2013
There are 28 for the 2nd month of year 2013
      </pre>

            <p>
                <b>[1 pt]</b> Lastly, be sure to write comments above your class to
                indicate the author of this file (you), acknowledgements for any
                external help you got, and what the purpose of this program is.
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">3. The Guessing Game [4 pts]</h3>
        </div>
        <div class="panel-body">
            <p>
                The following program asks the user to enter two "strings" (words) and
                see if one is a substring of another. For example, if the user enters
                "abcde" and "ab", then "ab" is a substring of the former. However, if
                the user enters "abcde" and "efg", then we can see that "efg" is not a
                substring of the former.
                Load this program into Eclipse and run it. You can type it in line by
                line as written below, or you can download it from this file <a
                        href="documents/CheckSubString.java"><tt>CheckSubString.java</tt></a>.
                Try running it a few times to see what it does.
      <pre>
1   import java.util.Scanner;
2
3   public class CheckSubString
4   {
5     public static void main(String[] args)
6     {
7       Scanner input = new Scanner(System.in);
8       System.out.print("Enter string s1: ");
9       String s1 = input.nextLine();
10
11      System.out.print("Enter string s2: ");
12      String s2 = input.nextLine();
13
14      if (s1.indexOf(s2) != -1)
15        System.out.println(s2 + " is a substring of " + s1);
16      else
17        System.out.println(s2 + " is not a substring of " + s1);
18    }
19  }
      </pre>
            <p>
                In this exercise, what we want you to do is to look closely at each line
                in the program and try to see if you can guess what it's doing.
                Don't worry if you can't understand everything exactly, just take a
                guess. The purpose of this activity is to get you comfortable with new
                Java code that you will be seeing in the next few weeks.

            <p>
                <b>[1 pt each]</b>
                In particular, answer the following questions by indicating the line
                number(s) in the program:
            <ol>
                <li>Which lines of code asks the user to enter the first string (word)
                    and records that into a variable?
                <li>Which lines of code asks the user to enter the second string (word)
                    and records that into a variable?
                <li>Which line of code uses a predefined method to check whether the
                    second string is a substring within the first string?
                <li>Which lines of code will display the correct response based on the
                    result?

            </ol>
            <b>Be careful</b> with the line numbers. Use the ones shown above (in
            case your version in Eclipse has different spacing and line numbers.
        </div>
    </div>
@endsection
@section('footer')
    {{--Sends pageview google anaytics--}}
    <script>
        ga('send', {
            hitType: 'pageview',
            title: 'Labs',
            page: '/labs'
        });
    </script>
@endsection