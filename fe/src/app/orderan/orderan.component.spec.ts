import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OrderanComponent } from './orderan.component';

describe('OrderanComponent', () => {
  let component: OrderanComponent;
  let fixture: ComponentFixture<OrderanComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [OrderanComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(OrderanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
