x=13
y=29
c=(y-x)
print(c)
# if from
if 5>2:
    print("five is greater than two")
# step into a little bit complex
print("Hello,World")
x="I'm Arnob . From Bangladesh"
print(x)
# time to step up
print("Hi,i'm Arnob",end="I'm From Bangladesh")
#now mix letter with variable and numbers
print("Hello.I'm Arnob",32,end="years old")
#today we learn numbers
x_new,y,z = "Assaduzzaman","Md","Arnob"
print(x_new)
print(y)
print(z)
#now learn about collectionof items
fruits=["apple","orange","grape"]
print(fruits)
#now we learn about character postition
a ="Hello,World"
print(a[6])
# learn about len 
a ="hello,Assaduzzaman"
print(len(a))
# learn in 
txt="assaduzzaman is not a intilligent boy "
print("intilligent" in txt)
if"brilliant"not in txt:
    print("sorry to say he is dumb")
#format string 
price=49
x="you broke the into 2 pices!"
txt=f"the price of the car was {price} dollars."
print(txt+" "+x)
#boolean 
a=15
b=15
if a<b:
    print("are you blind or what ? a is smaller than b")
elif a==b:
    print("i am really confused")
else:
    print("you are really blind bro")
    print(15%4)

# python a list .sort() use for sort the list in alpabetical order
thislist=["apple","cherry","mango","kiwi","pear"]
thislist.sort()
print(thislist)

# reverse =true method
thislist=["apple","cherry","mango","kiwi","pear"]
thislist.sort(reverse=True)
print(thislist)

# tuple method 
thistuple=("apple","orange","cherry","mango","kiwi")

if "starwberry" in thistuple:
    print("i will definitley eat starwberry")

else:
    print("Who eat my starwberry ?")