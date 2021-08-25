import random, pygame, sys
from pygame.locals import *

FPS = 30 # frames per second, brzina programa
WINDOWWIDTH = 640 # sirina prozora igre u pikselima
WINDOWHEIGHT = 480 # visina prozora igre u pikselima
REVEALSPEED = 8 # brzina prikazivanja i sakrivanja elemenata; ako stavimo na 1, trajace duze otkrivanje/pokrivanje
BOXSIZE = 40 # visina i sirina kartice sa elementom u pikselima
GAPSIZE = 10 # razmak izmedju kartica u pikselima
BOARDWIDTH = 10 # broj kolona kartica
BOARDHEIGHT = 7 # broj redova kartica
assert (BOARDWIDTH * BOARDHEIGHT) % 2 == 0, 'Tabla mora ima paran broj kartica za spajanje.'
XMARGIN = int((WINDOWWIDTH - (BOARDWIDTH * (BOXSIZE + GAPSIZE))) / 2)
YMARGIN = int((WINDOWHEIGHT - (BOARDHEIGHT * (BOXSIZE + GAPSIZE))) / 2)

#            R    G    B
GRAY     = (100, 100, 100)
NAVYBLUE = ( 60,  60, 100)
WHITE    = (255, 255, 255)
RED      = (255,   0,   0)
GREEN    = (  0, 255,   0)
BLUE     = (  0,   0, 255)
YELLOW   = (255, 255,   0)
ORANGE   = (255, 128,   0)
PURPLE   = (255,   0, 255)
CYAN     = (  0, 255, 255)

BGCOLOR = NAVYBLUE
LIGHTBGCOLOR = GRAY
BOXCOLOR = WHITE
HIGHLIGHTCOLOR = BLUE

DONUT = 'donut'
SQUARE = 'square'
DIAMOND = 'diamond'
LINES = 'lines'
OVAL = 'oval'

ALLCOLORS = (RED, GREEN, BLUE, YELLOW, ORANGE, PURPLE, CYAN)
ALLSHAPES = (DONUT, SQUARE, DIAMOND, LINES, OVAL)
# ovo znaci da mora postojati dovoljno kombinacija za velicinu table koju mi imamo
#npr posto imamo 7 boja i 5 oblika, to znaci da mozemo napraviti 35 drugacijih ikonica, odnosno da ukupno imamo 35*2
assert len(ALLCOLORS) * len(ALLSHAPES) * 2 >= BOARDWIDTH * BOARDHEIGHT, "Tabla je prevelika za broj definisanih oblika/broja."

def main():
    global FPSCLOCK, DISPLAYSURF # globalne varijable, sve sto se promeni unutar main-a, menja se i u ostatku koda
    pygame.init()
    FPSCLOCK = pygame.time.Clock()
    DISPLAYSURF = pygame.display.set_mode((WINDOWWIDTH, WINDOWHEIGHT)) #prikazivanje prozora igrice

    mousex = 0 # cuvanje x koordinate klika misa (mouse event)
    mousey = 0 # cuvanje y koordinate klima misa (mouse event)
    pygame.display.set_caption('Memory Game')

    # mainBoard je promenljiva koja 2D tablu mapira u 2D listu, tako da se pristupa matricno elementima
    # element mainBoard table izgleda u formatu [DONUT, BLUE] npr

    # revealedBoxes je promenljiva koja 2D tablu mapira u 2D listu, tako da se pristupa matricno elementima
    # razlika je sto sadrzi Boolean tipove, tj True ako je kartica sa koordinatama (x, y) otkrivena
    
    mainBoard = getRandomizedBoard() # shuffle kartica, tako da igra svaki put bude drugacija, odnosno vraca kombinacije za tu igru
    revealedBoxes = generateRevealedBoxesData(False) # funkcija koja postavlja sve kartice na neotkriveno

    # kada je prvi izbor, onda je None i cuvamo koordinate kliknute kartice
    # kada je drugi izbor, onda je vrednost u promenljivoj par koordinata, a ne None
    firstSelection = None # cuva par (x, y) prve kliknute kartice

    DISPLAYSURF.fill(BGCOLOR) #boji pozadinu
    startGameAnimation(mainBoard) #funkcija koja daje efekat mesanja kartica i sneak peak 

    while True: # beskonacna petlja koja traje dokle god traje igra
        #petlja vodi racuna o dogadjajima, azurira stanje igre i ispisuje ga tako da bude vidljiv korisniku
        mouseClicked = False

        #   Promenljive koje prate stanja igre su:
        #       mainBoard
        #       revealedBoxes
        #       firstSelection
        #       mouseClicked - daje True ako je igrac kliknuo misa tokom tekuce iteracije
        #       mousex
        #       mousey

        DISPLAYSURF.fill(BGCOLOR) 
        drawBoard(mainBoard, revealedBoxes) # funkcija koja stalno crta novo stanje table

        for event in pygame.event.get(): # event handling loop odnosno petlja koja izvrsava kod za svaki dogadjaj
            if event.type == QUIT or (event.type == KEYUP and event.key == K_ESCAPE): 
                pygame.quit()
                sys.exit()
            elif event.type == MOUSEMOTION: # pomeranje misa
                mousex, mousey = event.pos
            elif event.type == MOUSEBUTTONUP: # klik misa, postavlja mouseClicked na True
                mousex, mousey = event.pos
                mouseClicked = True

                #oba dogadjaja postavljaju kursor misa u promenljivama mousex i mousey

        boxx, boxy = getBoxAtPixel(mousex, mousey) # na osnovu koordinata misa, dobijamo konkretnu karticu na toj poziciji
        if boxx != None and boxy != None: 
            # promenljive su None u slucaju da je kursor van opsega table ili izmedju kartica
            if not revealedBoxes[boxx][boxy]:
                drawHighlightBox(boxx, boxy) # proveravamo da li je kartica otkrivena i ako nije postavljamo plavi okvir oko nje
            if not revealedBoxes[boxx][boxy] and mouseClicked: # ako kartica nije otkrivena i kliknuli smo na nju, otvaramo je
                revealBoxesAnimation(mainBoard, [(boxx, boxy)]) # funkcija za animaciju otvaranja kartice
                revealedBoxes[boxx][boxy] = True # postavljamo da je kartica otkrivena
                if firstSelection == None: # ako je prvi potez, postavljamo koordinate
                    firstSelection = (boxx, boxy)
                else: # u slucaju da je drugi potez, proveravamo da li je pogodak
                    # funkcije koje vraca boju i oblik oba elementa, tako da bismo mogli proveriti da li je match
                    icon1shape, icon1color = getShapeAndColor(mainBoard, firstSelection[0], firstSelection[1])
                    icon2shape, icon2color = getShapeAndColor(mainBoard, boxx, boxy)

                    if icon1shape != icon2shape or icon1color != icon2color:
                        # u slucaju da se nesto ne poklapa, zatvaramo kartice
                        pygame.time.wait(1000) # 1000 milliseconds = 1 sec pauziramo igricu
                        #funkcija za animaciju koja zatvara kartice
                        coverBoxesAnimation(mainBoard, [(firstSelection[0], firstSelection[1]), (boxx, boxy)])
                        #mapiramo da je kombinacija netacna
                        revealedBoxes[firstSelection[0]][firstSelection[1]] = False
                        revealedBoxes[boxx][boxy] = False
                    elif hasWon(revealedBoxes): # u slucaju da je match, proveravamo da li su sve kartice otkrivene
                        gameWonAnimation(mainBoard) # ako jeste, pozivamo funkciju za animaciju pobede
                        pygame.time.wait(2000) # cekamo 2 sec

                        # restartuje igricu
                        mainBoard = getRandomizedBoard()
                        revealedBoxes = generateRevealedBoxesData(False)

                        # na sekundu prikazuje potpuno otkrivene kartice
                        drawBoard(mainBoard, revealedBoxes)
                        pygame.display.update()
                        pygame.time.wait(1000)

                        # ponovo ponavlja animaciju za pocetak igre
                        startGameAnimation(mainBoard)
                    firstSelection = None # postavlja na prvi potez

        # ponovo iscrtavamo tablu i azuriramo promene, ako ih ima
        # cekamo otkucaj od 30 frames per second
        pygame.display.update()
        FPSCLOCK.tick(FPS)


# funkcija za postavljanje kartica koje su otkrivene
def generateRevealedBoxesData(val):
    revealedBoxes = []
    for i in range(BOARDWIDTH):
        revealedBoxes.append([val] * BOARDHEIGHT)
    return revealedBoxes


def getRandomizedBoard():
    # vraca listu svih mogucih kombinacija oblika i boja
    icons = []
    for color in ALLCOLORS:
        for shape in ALLSHAPES:
            icons.append( (shape, color) )

    random.shuffle(icons) # mesamo ikonice da ne bi bile iste uvek
    numIconsUsed = int(BOARDWIDTH * BOARDHEIGHT / 2) # racunamo koliko nam je ikonica potrebno
    icons = icons[:numIconsUsed] * 2 # dupliramo svaku
    random.shuffle(icons) # mesamo ikonice ponovo, da bismo dobili random raspored, jer su prva i druga polovina iste

    # pravimo strukturu table, sa random postavljenim ikonicama
    board = []
    for x in range(BOARDWIDTH):
        # za svaku kolonu na tabli, pravimo listu random selektovanih ikonica
        column = []
        for y in range(BOARDHEIGHT):
            column.append(icons[0])
            del icons[0] # cim dodamo ikonicu u kolonu, brisemo je iz liste, da bismo dodali sledece
        board.append(column) # svaku popunjenu kolonu dodajemo na tablu
    return board


# funkcija koju poziva funkcija za animaciju za pocetak igre
#deli listu u listu lista
def splitIntoGroupsOf(groupSize, theList):
    #unustrasnje liste imaju groupSize broj elemenata, a poslednja moze imati manje
    result = []
    for i in range(0, len(theList), groupSize): # (start, stop, step)
        result.append(theList[i:i + groupSize]) # pravi listu listi koje se dodaju rezultatu
    return result


# treba napomenuti da koristimo Kartezijanski koordinatni sistem, odnosno Dekartov koordinatni sistem
# koristimo jedan koordinatni sistem za koordinate, a jedan za kartice
# npr ako kazemo (3, 2) znaci da je red o kartici koja je 4 pocevsi od leve strane, a treca pocevsi od vrha
# gornji levi ugao je (0, 0)
def leftTopCoordsOfBox(boxx, boxy):
    # konvertovanje koordinata u piksele
    left = boxx * (BOXSIZE + GAPSIZE) + XMARGIN
    top = boxy * (BOXSIZE + GAPSIZE) + YMARGIN
    return (left, top)


# funkcija koja nam konvertuje piksele u kordinate table
def getBoxAtPixel(x, y):
    for boxx in range(BOARDWIDTH):
        for boxy in range(BOARDHEIGHT):
            left, top = leftTopCoordsOfBox(boxx, boxy)
            boxRect = pygame.Rect(left, top, BOXSIZE, BOXSIZE)
            # funkcija koja nam vraca True ako smo pronasli kutiju koja je
            # klinuta ili ako smo misem prosli i daje nam koordinate
            if boxRect.collidepoint(x, y):
                return (boxx, boxy)
    return (None, None)


# funkcija koja crta ikonice odredjenog oblika i boje na mesto odredjeno koordinatama
# obzirom da svaki oblik u biblioteci pygame ima drugaciju funkciju, imamo vise if uslova
def drawIcon(shape, color, boxx, boxy):
    quarter = int(BOXSIZE * 0.25) # prekalkulisane vrednosti
    half =    int(BOXSIZE * 0.5)  

    left, top = leftTopCoordsOfBox(boxx, boxy) # dobijamo piksele na osnovu koordinata table
    # crtanje oblika
    if shape == DONUT:
        pygame.draw.circle(DISPLAYSURF, color, (left + half, top + half), half - 5)
        pygame.draw.circle(DISPLAYSURF, BGCOLOR, (left + half, top + half), quarter - 5)
    elif shape == SQUARE:
        pygame.draw.rect(DISPLAYSURF, color, (left + quarter, top + quarter, BOXSIZE - half, BOXSIZE - half))
    elif shape == DIAMOND:
        pygame.draw.polygon(DISPLAYSURF, color, ((left + half, top), (left + BOXSIZE - 1, top + half), (left + half, top + BOXSIZE - 1), (left, top + half)))
    elif shape == LINES:
        for i in range(0, BOXSIZE, 4):
            pygame.draw.line(DISPLAYSURF, color, (left, top + i), (left + i, top))
            pygame.draw.line(DISPLAYSURF, color, (left + i, top + BOXSIZE - 1), (left + BOXSIZE - 1, top + i))
    elif shape == OVAL:
        pygame.draw.ellipse(DISPLAYSURF, color, (left, top + quarter, BOXSIZE, half))


# ova funkcija je odradjena samo radi bolje citljivosti koda i zato ima jednu liniju
def getShapeAndColor(board, boxx, boxy):
    # oblik za (x, y) vrednost je sacuvan u board[x][y][0]
    # boja za (x, y) vrednost je sacuvana u board[x][y][1]
    return board[boxx][boxy][0], board[boxx][boxy][1]


# funkcija za crtanje kartica koje prekrivaju oblike
# prosledjuje se tabla, lista (x, y) za svaku karitcu, i koliko treba prekriti
def drawBoxCovers(board, boxes, coverage):
    # posto koristimo isto crtanje za sve kartice, radimo sa for petljom
    # petlja radi tri stvari:
    #   crta pozadinsku boju
    #   crta ikonicu
    #   crta karticu koja treba da prekrije celu ikonicu
    for box in boxes:
        left, top = leftTopCoordsOfBox(box[0], box[1])
        pygame.draw.rect(DISPLAYSURF, BGCOLOR, (left, top, BOXSIZE, BOXSIZE))
        shape, color = getShapeAndColor(board, box[0], box[1])
        drawIcon(shape, color, box[0], box[1])
        if coverage > 0: # ako nije potrebno prekriti, ne crtamo karticu, a ako je 20 (BOXSIZE), to znaci da imamo 20 piksela siroku karticu
            pygame.draw.rect(DISPLAYSURF, BOXCOLOR, (left, top, coverage, BOXSIZE))
    # azuriramo stanje
    pygame.display.update()
    FPSCLOCK.tick(FPS)


# funkcija koja sluzi za otkrivanje kartica
def revealBoxesAnimation(board, boxesToReveal):
    #smanjujemo broj preostalih
    for coverage in range(BOXSIZE, (-REVEALSPEED) - 1, -REVEALSPEED):
        drawBoxCovers(board, boxesToReveal, coverage)


# funkcija koja sluzi za pokrivanje kartica
def coverBoxesAnimation(board, boxesToCover):
    # povecavamo broj dok ne dodjemo do kraja
    for coverage in range(0, BOXSIZE + REVEALSPEED, REVEALSPEED):
        drawBoxCovers(board, boxesToCover, coverage)



# funkcija za iscrtavanje table i svih otkrivenih i neotkrivenih kartica
def drawBoard(board, revealed):
    for boxx in range(BOARDWIDTH):
        for boxy in range(BOARDHEIGHT):
            left, top = leftTopCoordsOfBox(boxx, boxy)
            if not revealed[boxx][boxy]:
                # crtanje neotkrivene kartice
                pygame.draw.rect(DISPLAYSURF, BOXCOLOR, (left, top, BOXSIZE, BOXSIZE))
            else:
                # crtanje otkrivene kartice, odnosno crtanje ikonice
                shape, color = getShapeAndColor(board, boxx, boxy)
                drawIcon(shape, color, boxx, boxy)


# funkcija za crtanje neotkrivene kartice na kojoj je trenutno kursor
def drawHighlightBox(boxx, boxy):
    left, top = leftTopCoordsOfBox(boxx, boxy)
    pygame.draw.rect(DISPLAYSURF, HIGHLIGHTCOLOR, (left - 5, top - 5, BOXSIZE + 10, BOXSIZE + 10), 4)



# funkcija za animaciju koja se prikazuje na pocetku igre
# daje igracu pomoc, tako sto istovremeno otkriva i pokriva grupe kartica u isto vreme
# prvo se pravi lista svih mogucih mesta na tabli
def startGameAnimation(board):
    # otkriva random 8 kartica u isto vreme
    coveredBoxes = generateRevealedBoxesData(False)
    boxes = []
    for x in range(BOARDWIDTH):
        for y in range(BOARDHEIGHT):
            boxes.append( (x, y) )
    # da ne bi uvek otkrivali istu grupu
    random.shuffle(boxes)
    boxGroups = splitIntoGroupsOf(8, boxes) # delimo u grupe od po 8

    # crtamo tablu sa svim pokrivenim karticama,
    # a nakon toga pozivamo funkciju sa animacijom za otkrivanje grupe kartica,
    # kao i funkciju sa animacijom za sakrivanje tih kartica
    drawBoard(board, coveredBoxes)
    for boxGroup in boxGroups:
        revealBoxesAnimation(board, boxGroup)
        coverBoxesAnimation(board, boxGroup)


# funkcija koja se poziva u slucaju pobede igraca
def gameWonAnimation(board):
    # blica pozadinu u slucaju da igrac pobedi
    # postavlja da su sve kartice otkrivene
    coveredBoxes = generateRevealedBoxesData(True)
    color1 = LIGHTBGCOLOR
    color2 = BGCOLOR

    # petlja sluzi za konstantno menjanje vrednosti boja, tako da se dobija efekat blica
    # obzirom da se desava menjanje u jako kratkim vremenskim intervalima
    for i in range(13):
        color1, color2 = color2, color1
        DISPLAYSURF.fill(color1)
        drawBoard(board, coveredBoxes)
        pygame.display.update()
        pygame.time.wait(300)


# funkcija koja obavestava igraca da je pobedio
def hasWon(revealedBoxes):
    # ako su sve kartice otkrivene vraca True, u slucaju da je neka neotkrivena vraca False
    for i in revealedBoxes:
        if False in i:
            return False # vraca False ako je bilo koja kartica neotkrivena
    return True


if __name__ == '__main__':
    main()
