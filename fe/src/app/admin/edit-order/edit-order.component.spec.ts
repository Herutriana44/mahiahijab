import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminEditOrderComponent } from './edit-order.component';

describe('AdminEditOrderComponent', () => {
  let component: AdminEditOrderComponent;
  let fixture: ComponentFixture<AdminEditOrderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminEditOrderComponent]
    })
      .compileComponents();

    fixture = TestBed.createComponent(AdminEditOrderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
