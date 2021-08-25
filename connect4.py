import numpy as np
import pygame
import sys
import math

ROW_COUNT = 6
COLUMN_COUNT = 7
FONT_SIZE = 50

BLUE = (0, 0, 255)
DARK = (0, 0, 0)
RED = (255, 0, 0)
YELLOW = (255, 255, 0)

def create_board():
    global ROW_COUNT
    ROW_COUNT = int(input("Please, enter the row number:"))
    global COLUMN_COUNT
    COLUMN_COUNT = int(input("Please, enter the column number:"))
    while (ROW_COUNT <= 5 or COLUMN_COUNT <= 6):
        print("Please, input valid values for the board.")
        ROW_COUNT = int(input("Please, enter the row number:"))
        COLUMN_COUNT = int(input("Please, enter the column number:"))
    board = np.zeros((ROW_COUNT, COLUMN_COUNT)) #matrica nula, 6 redova i 7 kolona
    return board

def drop_piece(board, row, col, piece): #stavljanje figura
    board[row][col] = piece

def is_valid_location(board, col): #proverava na osnovu izbora igraca da li je pozicija validna
    return board[ROW_COUNT-1][col] == 0 #proveravamo da li je poslednji red popunjen

def get_next_open_row(board, col):
    for r in range(ROW_COUNT):
        if board[r][col] == 0:
            return r

def winning_move(board, piece): #proveravamo da li je neki igrac pobedio, nije najefikasnije
    #horizontalna provera
    for c in range(COLUMN_COUNT-3): #ne mogu poslednje tri kolone, jer treba 4 spojiti
        for r in range(ROW_COUNT):
            if board[r][c] == piece and board[r][c+1] == piece and board[r][c+2] == piece and board[r][c+3] == piece:
                return True
            
   #vertikalna provera
    for c in range(COLUMN_COUNT): 
        for r in range(ROW_COUNT-3): #ne mogu poslednja tri reda, jer treba 4 spojiti
            if board[r][c] == piece and board[r+1][c] == piece and board[r+2][c] == piece and board[r+3][c] == piece:
                return True

    #provera pozitivnih dijagonala
    for c in range(COLUMN_COUNT-3): 
        for r in range(ROW_COUNT-3): 
            if board[r][c] == piece and board[r+1][c+1] == piece and board[r+2][c+2] == piece and board[r+3][c+3] == piece:
                return True

    #provera negativnih dijagonala
    for c in range(COLUMN_COUNT-3): 
        for r in range(3, ROW_COUNT): 
            if board[r][c] == piece and board[r-1][c+1] == piece and board[r-2][c+2] == piece and board[r-3][c+3] == piece:
                return True        

def print_board(board): #funkcija koja nam je potrebna zbog orijentacije table, da bismo kretali od donjeg levog ugla
        print(np.flip(board, 0))
def draw_board(board):
    for c in range(COLUMN_COUNT):
        for r in range(ROW_COUNT):
            pygame.draw.rect(screen, BLUE, (c*SQUARESIZE, r*SQUARESIZE+SQUARESIZE, SQUARESIZE, SQUARESIZE))
            pygame.draw.circle(screen, DARK, (int(c*SQUARESIZE+SQUARESIZE/2), int(r*SQUARESIZE+SQUARESIZE+SQUARESIZE/2)), RADIUS)

    for c in range(COLUMN_COUNT):
        for r in range(ROW_COUNT):
            if board[r][c] == 1:
                 pygame.draw.circle(screen, RED, (int(c*SQUARESIZE+SQUARESIZE/2), height - int(r*SQUARESIZE+SQUARESIZE/2)), RADIUS)
            elif board[r][c] == 2:
                 pygame.draw.circle(screen, YELLOW, (int(c*SQUARESIZE+SQUARESIZE/2), height - int(r*SQUARESIZE+SQUARESIZE/2)), RADIUS)
    pygame.display.update()

board = create_board()
print_board(board)
game_over = False #false dok neko ne pobedi
turn = 0 #koji igrac je na potezu

pygame.init()
SQUARESIZE = 50 #pikseli

width = COLUMN_COUNT * SQUARESIZE
height = (ROW_COUNT + 1) * SQUARESIZE #jedan red vise za prikaz kruzica

size = (width, height)
RADIUS = int(SQUARESIZE/2 - 5)

screen = pygame.display.set_mode(size, pygame.RESIZABLE)
draw_board(board)
pygame.display.update()

def check_font(column):
    if(column > 5):
        global FONT_SIZE
        FONT_SIZE = 25 + column
    else:
        FONT_SIZE = column * column
    return FONT_SIZE

myfont = pygame.font.SysFont("monospace", check_font(COLUMN_COUNT))

while not game_over:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.display.quit()
            pygame.quit()
            sys.exit()

        if event.type == pygame.MOUSEMOTION:
            pygame.draw.rect(screen, DARK, (0, 0, width, SQUARESIZE))
            posx = event.pos[0]
            if turn == 0:
                pygame.draw.circle(screen, RED,(posx, int(SQUARESIZE/2)), RADIUS)
            else:
                pygame.draw.circle(screen, YELLOW,(posx, int(SQUARESIZE/2)), RADIUS)

        pygame.display.update()

        if event.type == pygame.MOUSEBUTTONDOWN:
            pygame.draw.rect(screen, DARK, (0, 0, width, SQUARESIZE))
            print(event.pos)
            #prvi igrac na potezu
            if turn == 0:
                posx = event.pos[0]
                col = int(math.floor(posx/SQUARESIZE))
                
                if is_valid_location(board, col):
                    row = get_next_open_row(board, col)
                    drop_piece(board, row, col, 1)

                    if(winning_move(board,1)):
                       label = myfont.render("Player 1 wins!", 1, RED)
                       screen.blit(label, (40, 10))
                       game_over = True
            else:
            #drugi igrac na potezu
                posx = event.pos[0]
                col = int(math.floor(posx/SQUARESIZE))
                
                if is_valid_location(board, col):
                    row = get_next_open_row(board, col)
                    drop_piece(board, row, col, 2)

                    if(winning_move(board,2)):
                       label = myfont.render("Player 2 wins!", 1, YELLOW)
                       screen.blit(label, (40, 10))
                       game_over = True

            print_board(board)
            draw_board(board)

            turn +=1
            turn = turn % 2 #menja konstantno igrace

            if game_over:
                pygame.time.wait(3000)
                pygame.display.quit()
                pygame.quit()
                

 


        
##    #prvi igrac na potezu
##    if turn == 0:
##        str1 = "Player 1 make your selection (0-" + str(COLUMN_COUNT-1) + "):"
##        col = int(input(str1)) #built in f-ja, vraca str
##        #print(selection)
##        #print(type(selection))
##        if is_valid_location(board, col):
##            row = get_next_open_row(board, col)
##            drop_piece(board, row, col, 1)
##
##            if(winning_move(board,1)):
##               print("PLAYER 1 WINS!!")
##               game_over = True
##    else:
##    #drugi igrac na potezu
##        str2 = "Player 2 make your selection (0-" + str(COLUMN_COUNT-1) + "):"
##        col = int(input(str2))
##        if is_valid_location(board, col):
##            row = get_next_open_row(board, col)
##            drop_piece(board, row, col, 2)
##
##            if(winning_move(board,2)):
##               print("PLAYER 2 WINS!!")
##               game_over = True
##
##    print_board(board)
##
##    turn +=1
##    turn = turn % 2 #menja konstantno igrace
##
