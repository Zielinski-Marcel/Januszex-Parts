import { getCurrentDate } from '@/Helpers/DateHelper.js';
import {vi,expect,it,describe,beforeEach,afterEach} from "vitest";

describe('getCurrentDate', () => {
    beforeEach(() => {
        // tell vitest we use mocked time
        vi.useFakeTimers()
    })

    afterEach(() => {
        // restoring date after each test run
        vi.useRealTimers()
    })

    it('should return the current date in YYYY-MM-DD format', () => {
        // Mock `Date` to always return a specific date
        const mockDate = new Date(2023, 4, 15); // May 15, 2023 (miesiące są zero-based)
        vi.setSystemTime(mockDate);

        // Call the function
        const result = getCurrentDate();

        // Expect the correct format
        expect(result).toBe('2023-05-15');
    });

    it('should pad the month and day with zeros if necessary', () => {
        // Mock `Date` for a single-digit month and day
        const mockDate = new Date(2023, 0, 8); // January 8, 2023
        vi.setSystemTime(mockDate);

        // Call the function
        const result = getCurrentDate();

        // Expect the correct format
        expect(result).toBe('2023-01-08');
    });
});
