execfile("statistics.py")
UE=input("Wieviele UE bisher? ")
f=open("Informatik II - Punktetabelle - SS15 - Tab1.csv","r")
newcontent="Pseudonym,"
for s in range(0,UE):
	newcontent+="UE_%02d,"%(s+1)
newcontent+="\n"
UEArr=[[] for i in range(UE)]
UECnt=[0]*UE
linecount=0
lines=f.read().split("\n")
for l in lines:
	if linecount==0:
		linecount+=1
		continue
	splits=l.split(",")
	#for s in splits:
	if not splits[0]=="": #pseudo set
		newcontent+=splits[0]+","
		for s in range(1,UE+1):
			if splits[5+s]=="":
				newcontent+="0,"
			else:
				newcontent+=""+splits[5+s]+","
				if not splits[0]=="Max" and not splits[0]=="Bsp":
					if splits[5+s]=="":
						splits[5+s]=0
					try:
						UEArr[s-1].append(int(splits[5+s]))
					except ValueError:
						UEArr[s-1].append(0)
						
				#UECnt[s-1]+=1
		newcontent+="\n"
		linecount+=1
	
newcontent+="Mean,"
for s in range(0,UE):
	#newcontent+=",%.2f"%(UEArr[s]/UECnt[s])
	#print mean(UEArr[s])
	newcontent+="%.2f"%mean(UEArr[s])+","
	#print median(UEArr[s])
newcontent+="\n"


fw=open("info2.dat","w")
fw.write(newcontent)
