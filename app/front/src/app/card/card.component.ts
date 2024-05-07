import { Component } from '@angular/core';
import { CardService } from './service/card.service';
import { Card } from './model/card';

@Component({
  selector: 'app-card',
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.css'],
})
export class CardComponent {
  cards: Card[] = [];
  sortedCards: Card[] = [];

  constructor(private cardService: CardService) {}

  getCards(size: number = 10): void {
    this.cardService.getCards(size).subscribe(
      (result: Card[]) => {
        this.cards = result;
      },
      (error: any) => {
        console.error('Error fetching cards:', error);
      },
    );
  }

  sortCards(): void {
    this.cardService.sortCards(this.cards).subscribe(
      (result: Card[]) => {
        this.sortedCards = result;
      },
      (error: any) => {
        console.error('Error sorting cards:', error);
      },
    );
  }
}
