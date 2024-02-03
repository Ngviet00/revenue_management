namespace RevenueManagement.Models.DTOs.User
{
    public class UserDto
    {
        public long Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public string Username { get; set; } = string.Empty;
        public string Phone { get; set; } = string.Empty;
        public string Emalil { get; set; } = string.Empty;
        public string Image { get; set; } = string.Empty;
        public int Sex { get; set; }
        public int RoldId { get; set; }
    }
}
